<?php
namespace App\Model\Core;
use App\Model\MagicObject;

/**
 * Entity abstract
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
abstract class Entity extends MagicObject
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_tableName;
    /**
     * Primary key
     *
     * @var string
     */
    protected $_primaryKey = 'id';
    /**
     * Data
     *
     * @var array
     */
    protected $_data = [];
    /**
     * Collection
     *
     * @var Entity\Collection
     */
    protected $_collection;

    /**
     * Object initialization
     *
     * @param Entity\Collection $collection Collection
     */
    public function __construct(Entity\Collection $collection)
    {
        $this->_collection = $collection;
    }

    /**
     * Load
     *
     * @return array
     */
    public function load()
    {
        if ($this->_isIdExist()) {
            return reset($this->_collection->load($this)->getData());
        }

        return null;
    }

    /**
     * Save
     *
     * @return $this
     */
    public function save()
    {
        $this->_beforeSave();
        
        if ($this->_isRowExist()) {
            $this->_collection->update($this);
        } else {
            $this->_collection->add($this);
        }

        return $this;
    }

    /**
     * Delete
     *
     * @return $this
     */
    public function delete()
    {
        $this->_collection->delete($this);

        return $this;
    }


    /**
     * Set ID
     *
     * @param number $id ID
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->_data[$this->_primaryKey] = $id;
        return $this;
    }
    /**
     * Get ID
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_data[$this->_primaryKey];
    }

    /**
     * Get primary key
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * Get collection
     *
     * @return Entity\Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }


    /**
     * Call before entity saving
     * 
     * @return $this
     */
    protected function _beforeSave()
    {
        return $this;
    }

    /**
     * Is ID exist
     *
     * @return bool
     */
    protected function _isIdExist()
    {
        return array_key_exists($this->_primaryKey, $this->_data) && $this->getId();
    }

    /**
     * Is row exist
     *
     * @return bool
     */
    protected function _isRowExist()
    {
        $loaded = $this->load();

        return array_key_exists($this->_primaryKey, $loaded) && $loaded[$this->_primaryKey];
    }
}
