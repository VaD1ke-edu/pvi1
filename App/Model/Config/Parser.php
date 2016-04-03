<?php
namespace App\Model\Config;

use App\App;
use App\Model\MagicObject;

/**
 * Config parser
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */

class Parser extends MagicObject
{
    /**
     * Config path
     *
     * @var string
     */
    protected $_configPath;

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
}
