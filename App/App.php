<?php
namespace App;

use App\Model\RouterException;

/**
 * Application
 *
 * @category   App
 * @package    App
 * @subpackage App
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class App
{
    /**
     * Dependency injection
     *
     * @var \Zend\Di\Di
     */
    private $_di;
    /**
     * Application root directory name
     *
     * @var string
     */
    private static $_rootDir;
    /**
     * Application views directory name
     *
     * @var string
     */
    private static $_viewDir;

    /**
     * Object initialization
     *
     * @param \Zend\Di\Di $di Dependency injection
     */
    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    /**
     * Run application
     *
     * @return mixed
     */
    public function run()
    {
        $routePath = $this->_getRoutePath();
        try {
            $router = new Model\Router($routePath);
            $controllerName = $router->getController();
            $actionName = $router->getAction();
            if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
                throw new RouterException('Class or method are not exist');
            }
        } catch (RouterException $e) {
            $controllerName = '\App\Controller\NoRouteController';
            $actionName = 'indexAction';
        }

        $dic = new Model\DiC($this->_di);
        $dic->assemble();

        /** @var \App\Controller\AbstractController $controller */
        $controller = new $controllerName($this->_di);
        $controller->preDispatch($routePath);
        if ($view = $controller->$actionName()) {
            $view->render();
        }
    }

    /**
     * Get root dir
     *
     * @return string
     */
    public static function getRootDir()
    {
        if (!self::$_rootDir) {
            self::$_rootDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
        }
        return self::$_rootDir;
    }

    /**
     * Get view dir
     *
     * @return string
     */
    public static function getViewDir()
    {
        if (!self::$_viewDir) {
            self::$_viewDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR);
        }
        return self::$_viewDir;
    }


    /**
     * Get route path
     *
     * @return string
     */
    protected function _getRoutePath()
    {
        $defaultPath = 'index_index';

        if (!isset($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/') {
            return $defaultPath;
        }

        if ($requestUri = explode('?', $_SERVER['REQUEST_URI'], 2)) {
            $requestUri = reset($requestUri);
        }

        $requestPath = array_filter(explode('/', $requestUri));

        if (count($requestPath) > 3) {
            $requestPath = reset($requestPath);
        }
        if (count($requestPath) == 1) {
            $requestPath[] = 'index';
        }
        if (reset($requestPath) == 'admin' && count($requestPath) < 3) {
            array_splice($requestPath, 1, 0, ['index']);
        }
        $requestPath = implode('_', $requestPath);

        return $requestPath;
    }
}
