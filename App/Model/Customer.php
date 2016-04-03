<?php
namespace App\Model;

use \App\Model\Core\Entity as EntityAbstract;

/**
 * Customer entity model
 *
 * @category   App
 * @package    App
 * @subpackage Bot
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Customer extends EntityAbstract
{
    /**
     * Customer ID column name
     */
    const COLUMN_CUSTOMER_ID = 'id';
    /**
     * Customer name column name
     */
    const COLUMN_CUSTOMER_NAME = 'name';
    /**
     * Customer name column name
     */
    const COLUMN_CUSTOMER_SURNAME = 'surname';
    /**
     * Customer email column name
     */
    const COLUMN_CUSTOMER_EMAIL = 'email';
    /**
     * Customer phone column name
     */
    const COLUMN_CUSTOMER_PHONE = 'phone';

    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName = 'customer';
}
