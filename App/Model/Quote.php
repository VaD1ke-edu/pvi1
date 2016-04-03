<?php
namespace App\Model;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Quote entity model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Quote extends EntityAbstract
{
    /**
     * Quote ID column name
     */
    const COLUMN_QUOTE_ID = 'id';
    /**
     * Customer email column name
     */
    const COLUMN_CUSTOMER_EMAIL = 'customer_email';
    /**
     * Quote total column name
     */
    const COLUMN_QUOTE_TOTAL = 'total';
    /**
     * Customer ID column name
     */
    const COLUMN_CUSTOMER_ID = 'customer_id';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'quote';
}
