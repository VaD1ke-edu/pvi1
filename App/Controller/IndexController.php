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
            echo $this->_prepareJsonResponse('Не POST запрос', 'fail');
            return;
        }
        $data = $_POST;
        if (!isset($data['id'])) {
            echo $this->_prepareJsonResponse('Не был передан ID товара', 'fail');
            return;
        }
        /** @var \App\Model\Product $product */
        $product = $this->_di->get('Product');
        $productData = $product->setId($data['id'])->load();

        if (!$productData) {
            echo $this->_prepareJsonResponse('Такой продукт не существует', 'fail');
            return;
        }
        $product->setData($productData);
        if ($product->getQty() <= 0) {
            echo $this->_prepareJsonResponse('Продукта нет в наличии', 'fail');
            return;
        }
        $product->setQty($product->getQty() - 1);
        $product->save();
        echo $this->_prepareJsonResponse('Товар был успешно куплен');
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