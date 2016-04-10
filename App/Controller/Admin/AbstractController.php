<?php
namespace App\Controller\Admin;

/**
 * Abstract admin controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class AbstractController extends \App\Controller\AbstractController
{
    /**
     * Login route
     */
    const LOGIN_ROUTE = 'admin_index_login';

    /**
     * Pre dispatch method
     * (for checking authentication, access control or something else before dispatch)
     *
     * @param string $route Route path
     * @return $this
     */
    public function preDispatch($route)
    {
        if (!$this->_isAdminLoggedIn() && $route != self::LOGIN_ROUTE) {
            return $this->_redirect('admin/login');
        }
        return $this;
    }


    /**
     * Check is request post
     *
     * @return bool
     */
    protected function _isPost()
    {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }
    

    /**
     * Is admin logged in
     *
     * @return bool
     */
    protected function _isAdminLoggedIn()
    {
        $session = $this->_di->get('Session');
        return $session->isAdminLoggedIn();
    }

    /**
     * Prepare view
     *
     * @param array $data Data
     * @return array
     */
    protected function _prepareView(array $data)
    {
        $data['layout'] = 'admin/base';
        $data['params']['session'] = $this->_di->get('Session');
        return $data;
    }
}
