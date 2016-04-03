<?php
namespace App\Config;

use App\App;

/**
 * Config parser
 *
 * @category   App
 * @package    App
 * @subpackage App
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */

class Parser
{
    /**
     * Config path
     *
     * @var string
     */
    protected $_configPath;
    /**
     * Underscore cache
     *
     * @var array
     */
    protected static $_underscoreCache = [];

    /**
     * Object initialization
     */
    public function __construct()
    {
        $this->_configPath = App::getRootDir() . 'Config' . DIRECTORY_SEPARATOR . 'Config.ini';
    }

    public function __get($name)
    {

    }

    /**
     * Get bot api
     *
     * @return string
     */
    public function getBotToken()
    {
        $config = parse_ini_file($this->_configPath);

        return $config['bot_token'];
    }

    /**
     * Get database name
     *
     * @return string
     */
    public function getDatabaseName()
    {
        $config = parse_ini_file($this->_configPath);

        return $config['database_name'];
    }

    /**
     * Converts config field names for magic getters
     *
     * @param string $name Method name
     * @return string
     */
    protected function _underscore($name)
    {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }

        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;
        return $result;
    }
}
