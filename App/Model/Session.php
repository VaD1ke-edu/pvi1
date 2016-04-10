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

    /**
     * Auth admin
     * 
     * @param AdminUser $admin Admin user
     * @return bool
     */
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

    /**
     * Logout admin
     * 
     * @return $this
     */
    public function logoutAdmin()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        return $this;
    }

    /**
     * Is admin logged in
     * 
     * @return bool
     */
    public function isAdminLoggedIn()
    {
        return isset($_SESSION['admin']);
    }

    /**
     * Get admin
     * 
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->isAdminLoggedIn() ? $_SESSION['admin'] : null;
    }

    /**
     * Get session ID
     * 
     * @return mixed
     */
    public function getSessionId()
    {
        return session_id();
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