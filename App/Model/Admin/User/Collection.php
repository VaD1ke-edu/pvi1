<?php
namespace App\Model\Admin\User;

use App\Model\Admin\User as AdminUser;
use \App\Model\Core\Entity\Collection as CollectionAbstract;

/**
 * Admin user entity collection
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Collection extends CollectionAbstract
{
    /**
     * Find by username
     *
     * @param AdminUser $adminUser Admin user model
     * @return $this
     */
    public function findByName(AdminUser $adminUser)
    {
        $this->_entity = $adminUser;
        $this->_sqlObject = $this->getSelect();
        $this->_sqlObject
            ->from($adminUser->getTableName())
            ->where([AdminUser::COLUMN_USERNAME => $adminUser->getName()]);
        return $this;
    }
}
