<?php
namespace App\Model\Config;

use App\App;

/**
 * Config parser
 *
 * @category   App
 * @package    App
 * @subpackage Model
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
        $this->_configPath = App::getRootDir() . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Config.ini';
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
     * Get database driver name
     *
     * @return string
     */
    public function getDatabaseDriverName()
    {
        $config = parse_ini_file($this->_configPath);

        return $config['database_driver'];
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
