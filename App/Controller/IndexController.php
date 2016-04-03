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
class IndexController extends AbstractController
{
    /**
     * List action
     *
     * @return null|object
     */
    public function indexAction()
    {
//        $resource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product()]);
//        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
//        $paginator
//            ->setItemCountPerPage(2)
//            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
//        $pages = $paginator->getPages();
//        $product = $this->_di->get('Product');
//        $products = $this->_di->get('ProductCollection', ['resource' => $resource, 'productPrototype' => $product]);
        /** @var \App\Model\Employee $employee */
//        $employee = $this->_di->get('Employee');




        return $this->_di->get('View', [
            'template' => 'home',
//            'params'   => ['companies' => $this->_getCompanies()],
//            'params'   => ['products' => $products, 'pages' => $pages]
        ]);
    }

    public function viewAction()
    {
        $this->_di->get('Session')->generateToken();
        $product = $this->_di->get('Product');
        $product->load($_GET['id']);
        $reviews = $this->_di->get('ProductReviewCollection');
        $reviews->filterByProduct($product);
        return $this->_di->get('View', [
            'template' => 'product_view',
            'params'   => ['product' => $product, 'reviews' => $reviews]
        ]);
    }

    protected function _getCompanies()
    {
        /** @var \App\Model\Company $company */
        $company = $this->_di->get('Company');
        return $company->getCollection()->loadAll($company);
    }
}