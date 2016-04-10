<?php

namespace App\Controller\Admin;

use \App\Model\Product as Product;

/**
 * Category controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class CategoryController extends AbstractController
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
        return $this->_di->get('View', $this->_prepareView([
            'template' => 'admin/category/list',
            'params'   => ['categories' => $this->_getCategories()],
        ]));
    }

    /**
     * Product editing action
     *
     * @return $this|object
     */
    public function editAction()
    {
        if (!isset($_GET['id']) || !($categoryId = $_GET['id'])) {
            return $this->_redirect('admin/category/list');
        }

        /** @var \App\Model\Category $category */
        $category   = $this->_di->get('Category');
        $category->setId($categoryId);
        $categories = $category->getCollection()->load($category);

        if (!($category = $categories->fetchItem())) {
            return $this->_redirect('admin/category/list');
        }

        return $this->_di->get('View', $this->_prepareView([
            'template' => 'admin/category/edit',
            'params'   => [
                'category' => $category,
            ],
        ]));
    }
    
    public function newAction()
    {
        return $this->_di->get(
            'View', $this->_prepareView(['template' => 'admin/category/new'])
        );
    }

    /**
     * Product saving action
     *
     * @return $this
     */
    public function saveAction()
    {        
        $post = $_POST['category'];
        if (!$post) {
            return $this->_redirect('admin/category/list');
        }

        /** @var \App\Model\Category $category */
        $category = $this->_di->get('Category');
        $category->setData($post);
        $category->save();
        
        return $this->_redirect('admin/category/list');
    }

    /**
     * Delete action
     * 
     * @return $this
     */
    public function deleteAction()
    {
        if (!isset($_GET['id']) || !($categoryId = $_GET['id'])) {
            return $this->_redirect('admin/category/list');
        }
        
        /** @var \App\Model\Category $category */
        $product = $this->_di->get('Category');
        $product->setId($categoryId)->delete();
        
        return $this->_redirect('admin/category/list');
    }


    /**
     * Get categories
     *
     * @return \App\Model\Core\Entity\Collection
     */
    protected function _getCategories()
    {
        /** @var \App\Model\Category $category */
        $category = $this->_di->get('Category');
        return $category->getCollection()->loadAll($category);
    }
}