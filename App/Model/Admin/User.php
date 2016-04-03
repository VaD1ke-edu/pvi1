<?php
namespace App\Model\Admin;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Admin entity model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class User extends EntityAbstract
{
    /**
     * User ID column name
     */
    const COLUMN_ITEM_ID = 'id';
    /**
     * Username column name
     */
    const COLUMN_USERNAME = 'name';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'admin_user';
}
