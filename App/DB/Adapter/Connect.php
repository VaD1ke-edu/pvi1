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
                 . '..' . DIRECTORY_SEPARATOR . "Database/pvi1.db";

        self::$_adapter = new Adapter([
            'driver'   => 'Pdo_Sqlite',
            'database' => $dbName
        ]);

        return self::$_adapter;
    }
}
