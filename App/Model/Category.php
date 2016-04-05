<?php
namespace App\Model;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Category entity model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
/**
 * @method string getName()
 * @method $this  setName(string $name)
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
