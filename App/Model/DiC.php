<?php
namespace App\Model;

use App\App;
use Zend\Di\Di;
use Zend\Di\InstanceManager;

/**
 * Dependency injection controller
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class DiC
{
    /**
     * Dependency injection
     *
     * @var Di
     */
    private $_di;

    /**
     * Instance manger
     *
     * @var InstanceManager
     */
    private $_im;

    /**
     * Object initialization
     *
     * @param Di $di Dependency injection
     */
    public function __construct(Di $di)
    {
        $this->_di = $di;
        $this->_im = $di->instanceManager();
    }

    /**
     * Assemble
     *
     * @return void
     */
    public function assemble()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $_method) {
            if ($this->_isMethodAssembling($_method)) {
                $_method->setAccessible(true);
                $_method->invoke($this);
            }
        }
    }


    /**
     * Is method assembling (has prefix _assemble)
     *
     * @param \ReflectionMethod $method Reflection method
     *
     * @return bool
     */
    protected function _isMethodAssembling(\ReflectionMethod $method)
    {
        return strpos($method->getName(), '_assemble') === 0;
    }


    /**
     * Assemble adapter
     *
     * @return void
     */
    private function _assembleCollection()
    {
        $this->_im->setParameters('App\DB\Adapter\Connect', ['config' => 'App\Model\Config\Parser']);
        $this->_im->setParameters('Zend\Db\Sql\Sql', [
            'adapter' => $this->_di->get('App\DB\Adapter\Connect')->getAdapter()
        ]);

        $this->_im->setParameters('App\Model\Entity\Collection', ['sql' => $this->_di->get('Zend\Db\Sql\Sql')]);
    }

    /**
     * Assemble entities
     *
     * @return void
     */
    private function _assembleEntities()
    {
        $this->_im->addAlias('Employee', 'App\Model\Employee');
        $this->_im->addAlias('Category', 'App\Model\Category');
        $this->_im->addAlias('Company', 'App\Model\Company');

        $this->_im->setParameters(
            'Employee', ['collection' => $this->_di->newInstance('App\Model\Core\Entity\Collection')]
        );
        $this->_im->setParameters(
            'Category', ['collection' => $this->_di->newInstance('App\Model\Core\Entity\Collection')]
        );
        $this->_im->setParameters(
            'Company', ['collection' => $this->_di->newInstance('App\Model\Core\Entity\Collection')]
        );
    }

    /**
     * Assemble bot
     *
     * @return void
     */
    private function _assembleBot()
    {
//        $this->_im->setParameters('App\Bot\Api', ['config' => 'App\Config\Parser']);
//        $this->_im->addAlias('BotApi', 'App\Bot\Api');
//
//        $this->_im->setParameters('App\Bot\Handler', ['di' => $this->_di]);
//        $this->_im->addAlias('BotHandler', 'App\Bot\Handler');
//
//        $this->_im->setParameters('App\Bot\Updater', [
//            'api'        => $this->_di->get('BotApi'),
//            'lastUpdate' => $this->_di->get('LastUpdate'),
//        ]);
//        $this->_im->addAlias('BotUpdater', 'App\Bot\Updater');
    }

    /**
     * Assemble bot commands
     *
     * @return void
     */
    private function _assembleBotCommands()
    {
//        $this->_im->setParameters('App\Bot\CommandAbstract', ['botApi' => $this->_di->get('BotApi')]);
//        $this->_im->setParameters('App\Bot\Command\Register', [
//            'chat'      => $this->_di->get('Chat'),
//            'userIssue' => $this->_di->get('UserIssue'),
//            'userKey'   => $this->_di->get('UserKey'),
//        ]);
//        $this->_im->setParameters('App\Bot\Command\Deregister', [
//            'chat'   => $this->_di->get('Chat')
//        ]);
    }

    /**
     * Assemble view
     *
     * @return void
     */
    private function _assembleView()
    {
        $this->_im->setParameters('\App\Model\View\Renderer', [
            'layoutDir'   => App::getViewDir() . 'layout' . DIRECTORY_SEPARATOR,
            'templateDir' => App::getViewDir() . 'template' . DIRECTORY_SEPARATOR,
            'layout'      => 'base',
            'params'      => [],
        ]);
        $this->_im->addAlias('View', 'App\Model\View\Renderer');
    }
}
