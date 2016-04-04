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
}