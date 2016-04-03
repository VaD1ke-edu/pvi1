<?php

namespace App\Controller;
use App\Model\Core\Entity\Collection;

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
     * List action
     *
     * @return null|object
     */
    public function indexAction()
    {
        return $this->_di->get('View', [
            'template' => 'home',
            'params'   => ['products' => $this->_getProducts()],
        ]);
    }

    public function viewAction()
    {
        $this->_di->get('Session')->generateToken();
        $product = $this->_di->get('Product');
        $product->load($_GET['id']);
        return $this->_di->get('View', [
            'template' => 'product_view',
            'params'   => ['product' => $product]
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