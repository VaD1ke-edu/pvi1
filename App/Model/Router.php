<?php
namespace App\Model;

/**
 * Router
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Router
{
    /**
     * Is admin route
     *
     * @var bool
     */
    protected $_isAdminRoute = false;
    /**
     * Controller name
     *
     * @var string
     */
    protected $_controller;
    /**
     * Action name
     *
     * @var string
     */
    protected $_action;

    /**
     * Object initialization
     *
     * @param string $route Route
     * @throws RouterException
     */
    public function __construct($route)
    {
        $parsedRoute = explode('_', $route);
        if (sizeof($parsedRoute) != 2) {
            if (!(reset($parsedRoute) === 'admin' && sizeof($parsedRoute) === 3)) {
                throw new RouterException('Invalid route path');
            }
            $this->_isAdminRoute = true;
            array_shift($parsedRoute);
        }
        list($this->_controller, $this->_action) = $parsedRoute;
    }

    /**
     * Get controller class name
     *
     * @return string
     */
    public function getController()
    {
        $controller = ucfirst($this->_controller);
        if ($this->_isAdminRoute) {
            $controller = 'Admin\\' . $controller;
        }
        return '\\App\\Controller\\' . $controller . 'Controller';
    }

    /**
     * Get action method name
     *
     * @return string
     */
    public function getAction()
    {
        return lcfirst($this->_action) . 'Action';
    }
}
