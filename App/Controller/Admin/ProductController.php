<?php

namespace App\Controller\Admin;

use \App\Model\Product as Product;

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
        /** @var \App\Model\Category $category */
        $category = $this->_di->get('Category');
        $categories = $category->getCollection()->loadAll($category);

        if (!($product = $products->fetchItem())) {
            return $this->_redirect('admin/products');
        }

        return $this->_di->get('View', [
            'template' => 'admin/product/edit',
            'params'   => [
                'product'    => $product,
                'categories' => $categories,
            ],
        ]);
    }

    /**
     * Product saving action
     *
     * @return $this
     */
    public function saveAction()
    {
        $post = $_POST['product'];
        if (!$post) {
            return $this->_redirect('admin/product/list');
        }

        /** @var \App\Model\Product $product */
        $product = $this->_di->get('Product');
        
        $product->setData($post);
        if (!($_FILES && array_key_exists('product', $_FILES))) {
            return $this->_redirect('admin/product/list');
        }

        /** @var \App\Model\File\Uploader $uploader */
        $uploader = $this->_di->get('FileUploader');
        $imageName = $uploader->setPath(Product::IMAGES_DIR)
            ->setFileFieldName('image')
            ->setFileData($_FILES['product'])
            ->upload();
        if ($imageName) {
            $product->setImage($imageName);
        }
        $product->save();
        
        return $this->_redirect('admin/product/list');
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