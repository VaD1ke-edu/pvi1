<?php
namespace App\Model;

use \App\Model\Admin\User as AdminUser;
use \App\Model\Customer as Customer;

/**
 * Session model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Session
{
    /**
     * Dependency injector
     *
     * @var \Zend\Di\Di
     */
    private $_di;

    /**
     * Session constructor
     * @param \Zend\Di\Di $di Dependency injector
     */
    public function __construct($di)
    {
        $this->_di = $di;
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function register(array $customerData)
    {
        $customerData['password'] = $this->_hashPassword($customerData['password']);
        /** @var Customer $customer */
        $customer = $this->_di->newInstance('Customer');
        $customer->setData($customerData);
        try {
            $customer->save();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function auth(Customer $customer)
    {
        $customers = new DBCollection(PDOHelper::getPdo(), new CustomerTable);
        $customers->filterBy('login', $customer->getLogin());
        $customers->filterBy('password', $this->_hashPassword($customer->getPassword()));

        try {
            $fetchedCustomers = $customers->fetch();
        } catch (\Exception $ex) {
            $fetchedCustomers = [];
            var_dump($ex);
        }

        if (count($fetchedCustomers) == 1) {
            $_SESSION['customer'] = new Customer(reset($fetchedCustomers));

            return true;
        } else {
            return false;
        }
    }

    public function authAdmin(AdminUser $admin)
    {
        $adminLoginData = $admin->getData();
        try {
            /** @var \App\Model\Admin\User\Collection $admins */
            $admins = $admin->getCollection();
            $admins->findByName($admin);
            /** @var AdminUser $fetchedAdmin */
            $fetchedAdmin = $admins->fetchItem();
        } catch (\Exception $ex) {
            $fetchedAdmin = null;
        }

        if (!$fetchedAdmin || !$this->_verifyPassword($adminLoginData['password'], $fetchedAdmin->getPassword())) {
            return false;
        }

        $_SESSION['admin'] = $fetchedAdmin->getName();
        return true;
    }

    public function logout()
    {
        if (isset($_SESSION['customer'])) {
            unset($_SESSION['customer']);
        }
    }

    public function logoutAdmin()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['customer']);
    }

    public function isAdminLoggedIn()
    {
        return isset($_SESSION['admin']);
    }


    public function getCustomer()
    {
        return $this->isLoggedIn() ? $_SESSION['customer'] : null;
    }

    public function getAdmin()
    {
        return $this->isAdminLoggedIn() ? $_SESSION['admin'] : null;
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function generateToken()
    {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function getToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    public function validateToken($token)
    {
        $valid = $this->getToken() === $token;
        unset($_SESSION['token']);
        return $valid;
    }

    public function getQuoteId()
    {
        return isset($_SESSION['quote_id']) ? $_SESSION['quote_id'] : null;
    }

    public function setQuoteId($id)
    {
        $_SESSION['quote_id'] = $id;
    }


    /**
     * Hash password
     *
     * @param string $password Password
     * @return string
     */
    protected function _hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify password
     *
     * @param string $password Password
     * @param string $hash     Hash
     *
     * @return bool
     */
    protected function _verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}