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
class NoRouteController
{
    public function indexAction()
    {
        require_once App::getViewDir() . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . '404.phtml';
    }
}