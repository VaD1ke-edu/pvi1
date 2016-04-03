<?php
namespace App\Controller\Admin;

use Zend\Di\Di;

/**
 * Abstract admin controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class AbstractController
{
    /**
     * Dependency injector
     *
     * @var Di
     */
    protected $_di;

    /**
     * Controller initialization
     *
     * @param Di $di Dependency injector
     */
    public function __construct(Di $di)
    {
        $this->_di = $di;
    }

    /**
     * Pre dispatch method
     * (for checking authentication, access control or something else before dispatch)
     *
     * @return $this
     */
    public function preDispatch()
    {
        return $this;
    }


    /**
     * Redirect
     *
     * @param string $page   Page to redirect
     * @param array  $params Params
     *
     * @return void
     */
    protected function _redirect($page, $params = [])
    {
        $urlParams = ['page' => $page];
        $urlParams = array_merge($urlParams, $params);
        header('Location: /?' . \http_build_query($urlParams));
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

    
    private function _isAdminLoggedIn()
    {
        $session = $this->_di->get('Session');
        if (!$session->isAdminLoggedIn()) {
            $this->_redirect('admin_login');
        }
    }
}
