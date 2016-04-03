<?php
namespace App;

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
        try {
            $defaultPath = 'index_index';
            $routePath = isset($_GET['page']) ? $_GET['page'] : $defaultPath ;
            $router = new Model\Router($routePath);
            $controllerName = $router->getController();
            $actionName = $router->getAction();
            if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
                throw new Model\RouterException('Class or method are not exist');
            }
        } catch (Model\RouterException $e) {
            $controllerName = '\App\Controller\NoRouteController';
            $actionName = 'notFoundAction';
        }

        $dic = new Model\DiC($this->_di);
        $dic->assemble();

        $controller = new $controllerName($this->_di);
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
}
