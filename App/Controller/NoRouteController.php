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
    public function indexAction()
    {
        require_once App::getViewDir() . DS . 'template' . DS . '404.phtml';
    }
}