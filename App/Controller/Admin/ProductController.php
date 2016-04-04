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
class ProductController extends AbstractController
{
    /**
     * Index action
     *
     * @return $this|object
     */
    public function indexAction()
    {
        return $this->listAction();
    }

    /**
     * Products action
     *
     * @return $this|object
     */
    public function listAction()
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
    public function editAction()
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