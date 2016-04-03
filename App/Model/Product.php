<?php
namespace App\Model;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Product entity model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */

/**
 * @method string getName()
 * @method $this  setName(string $name)
 * @method string getPrice()
 * @method $this  setPrice(float $password)
 * @method string getQty()
 * @method $this  setQty(int $qty)
 * @method string getCategoryId()
 * @method $this  setCategoryId(int $categoryId)
 */
class Product extends EntityAbstract
{
    /**
     * Product ID column name
     */
    const COLUMN_PRODUCT_ID = 'id';
    /**
     * Product name column name
     */
    const COLUMN_PRODUCT_NAME = 'name';
    /**
     * Product price column name
     */
    const COLUMN_PRODUCT_PRICE = 'price';
    /**
     * Product quantity column name
     */
    const COLUMN_PRODUCT_QUANTITY = 'qty';
    /**
     * Category ID column name
     */
    const COLUMN_CATEGORY_ID = 'category_id';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'product';
}
