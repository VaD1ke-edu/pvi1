<?php

namespace App\Controller;

/**
 * Index controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class AdminController extends AbstractController
{
    /**
     * Login route
     */
    const LOGIN_ROUTE = 'admin_login';

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
            return $this->_redirect('admin/products');
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

    /**
     * Products action
     *
     * @return $this|object
     */
    public function productsAction()
    {
        return $this->_di->get('View', [
            'template' => 'admin/product/list',
            'params'   => ['products' => $this->_getProducts()],
        ]);
    }

    /**
     * Product editing action
     * 
     * @return $this|object
     */
    public function productEditAction()
    {
        if (!isset($_GET['id']) || !($productId = $_GET['id'])) {
            return $this->_redirect('admin/products');
        }

        /** @var \App\Model\Product $product */
        $product   = $this->_di->get('Product');
        $product->setId($productId);
        $products = $product->getCollection()->load($product);

        if (!($product = $products->fetchItem())) {
            return $this->_redirect('admin/products');
        }

        return $this->_di->get('View', [
            'template' => 'admin/product/edit',
            'params'   => ['product' => $product],
        ]);
    }


    /**
     * Get products
     *
     * @return Collection
     */
    protected function _getProducts()
    {
        /** @var \App\Model\Product $product */
        $product = $this->_di->get('Product');
        return $product->getCollection()->loadAll($product);
    }


    /**
     * Is admin logged in
     *
     * @return bool
     */
    private function _isAdminLoggedIn()
    {
        $session = $this->_di->get('Session');
        return $session->isAdminLoggedIn();
    }
}