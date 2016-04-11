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
            'params'   => [
                'products' => $this->_getProducts(),
                'categories' => $this->_getCategories(),
            ],
        ]);
    }

    /**
     * Buy product action
     * 
     * @return void
     */
    public function buyAction()
    {
        $this->_prepareJsonAction();
        if (!$this->_isPost()) {
            echo json_encode('Not a post action');
            return;
        }
        $data = $_POST;
        if (!isset($data['id'])) {
            echo json_encode('No ID was sent');
            return;
        }
        /** @var \App\Model\Product $product */
        $product = $this->_di->get('Product');
        $productData = $product->setId($data['id'])->load();

        if (!$productData) {
            echo json_encode('Product with this ID doesn\'t exist');
            return;
        }
        $product->setData($productData);
        if ($product->getQty() <= 0) {
            echo json_encode('Product is out of stock');
            return;
        }
        $product->setQty($product->getQty() - 1);
        $product->save();
        echo json_encode('Product was successfully bought');
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
     * Get categories
     *
     * @return Collection
     */
    protected function _getCategories()
    {
        /** @var \App\Model\Category $category */
        $category = $this->_di->get('Category');
        return $category->getCollection()->loadAll($category);
    }
}