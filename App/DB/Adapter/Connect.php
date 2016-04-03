<?php
namespace App\DB\Adapter;

use \Zend\Db\Adapter\Adapter;

/**
 * Database connect
 *
 * @category   App
 * @package    App
 * @subpackage DB
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Connect
{
    /**
     * Database connection
     *
     * @var Adapter
     */
    private static $_adapter;
    /**
     * Config parser
     *
     * @var \App\Model\Config\Parser
     */
    protected static $_config;

    /**
     * Object initialization
     *
     * @param \App\Model\Config\Parser $config Config parser
     */
    public function __construct($config)
    {
        self::$_config = $config;
    }

    /**
     * Connect database
     *
     * @return bool|Adapter
     */
    public static function getAdapter()
    {
        if (self::$_adapter) {
            return self::$_adapter;
        }

        $dbName = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                 . '..' . DIRECTORY_SEPARATOR . self::$_config->getDatabaseName();

        self::$_adapter = new Adapter([
            'driver'   => self::$_config->getDatabaseDriverName(),
            'database' => $dbName
        ]);

        return self::$_adapter;
    }
}
