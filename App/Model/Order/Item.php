<?php
namespace App\Model\Order;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Order item entity model
 *
 * @category   App
 * @package    App
 * @subpackage Bot
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Item extends EntityAbstract
{
    /**
     * Order item ID column name
     */
    const COLUMN_ITEM_ID = 'id';
    /**
     * Order ID column name
     */
    const COLUMN_ORDER_ID = 'order_id';
    /**
     * Product ID column name
     */
    const COLUMN_PRODUCT_ID = 'product_id';
    /**
     * Items quantity column name
     */
    const COLUMN_QUANTITY = 'qty';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'order_item';
}
