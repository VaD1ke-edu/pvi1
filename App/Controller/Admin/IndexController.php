<?php

namespace App\Controller\Admin;

/**
 * Index controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class IndexController extends AbstractController
{
    /**
     * Index action
     *
     * @return $this|object
     */
    public function indexAction()
    {
        return $this->loginAction();
    }

    /**
     * Login action
     *
     * @return $this|object
     */
    public function loginAction()
    {
        if (!isset($_POST['admin'])) {
            return $this->_di->get('View', [
                'template' => 'admin/login',
            ]);
        }
        
        /** @var \App\Model\Admin\User $admin */
        $admin   = $this->_di->get('AdminUser');
        $admin->setData($_POST['admin']);
        /** @var \App\Model\Session $session */
        $session = $this->_di->get('Session');

        if ($session->authAdmin($admin)) {
            return $this->_redirect('admin/product/list');
        }

        return $this->_redirect('index');
    }

    /**
     * Logout action
     *
     * @return $this
     */
    public function logoutAction()
    {
        /** @var \App\Model\Session $session */
        $session = $this->_di->get('Session');
        $session->logoutAdmin();
        return $this->_redirect('admin');
    }
}