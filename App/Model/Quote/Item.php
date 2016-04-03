<?php
namespace App\Model\Quote;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Quote item entity model
 *
 * @category   App
 * @package    App
 * @subpackage Bot
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Item extends EntityAbstract
{
    /**
     * Quote item ID column name
     */
    const COLUMN_ITEM_ID = 'id';
    /**
     * Quote ID column name
     */
    const COLUMN_QUOTE_ID = 'quote_id';
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
    protected $_tableName = 'quote_item';
}
