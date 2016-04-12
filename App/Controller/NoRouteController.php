<?php
namespace App\Controller;

use App\App;

/**
 * No route controller
 *
 * @category   App
 * @package    App
 * @subpackage Controller
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class NoRouteController extends AbstractController
{
    /**
     * No route action
     * @return void
     */
    public function indexAction()
    {
        require_once App::getViewDir() . DS . 'template' . DS . '404.phtml';
    }
}