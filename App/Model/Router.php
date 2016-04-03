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
            throw new RouterException('Invalid route path');
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
        return '\\App\\Controller\\' . ucfirst($this->_controller) . 'Controller';
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
