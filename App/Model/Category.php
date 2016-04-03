<?php
namespace App\Model;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Category entity model
 *
 * @category   App
 * @package    App
 * @subpackage Bot
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Category extends EntityAbstract
{
    /**
     * Column ID column name
     */
    const COLUMN_CATEGORY_ID = 'id';
    /**
     * Category name column name
     */
    const COLUMN_CATEGORY_NAME = 'name';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'category';
}
