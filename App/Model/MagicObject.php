<?php
namespace App\Model;

/**
 * Magic object
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class MagicObject
{
    /**
     * Data
     *
     * @var array
     */
    protected $_data = [];
    /**
     * Underscore cache
     *
     * @var array
     */
    protected static $_underscoreCache = [];

    /**
     * Get field value
     *
     * @param string $name Field name
     * @return mixed
     */
    public function __get($name)
    {
        $var = $this->_underscore($name);
        return $this->getData($var);
    }

    /**
     * Magic method for calling methods
     *
     * @param string $method Method name
     * @param array  $args   Args
     *
     * @return MagicObject|array
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get' :
                $key = $this->_underscore(substr($method,3));
                $data = $this->getData($key);
                return $data;
            case 'set' :
                $key = $this->_underscore(substr($method,3));
                $result = $this->setData(isset($args[0]) ? $args[0] : null, $key);
                return $result;
        }
        throw new \Exception("Invalid method " . get_class($this) . "::" . $method . "(" . print_r($args,1) . ")");
    }

    /**
     * Set data
     *
     * @param mixed  $data Data
     * @param string $key  Key
     *
     * @return $this
     */
    public function setData($data, $key = null)
    {
        if ($key) {
            $this->_data[$key] = $data;
            return $this;
        }

        if (is_array($data)) {
            $this->_data = $data;
        }

        return $this;
    }

    /**
     * Get data
     *
     * @param string $param Parameter
     * @return array
     */
    public function getData($param = '')
    {
        if ($param) {
            if (array_key_exists($param, $this->_data)) {
                return $this->_data[$param];
            }
            return null;
        }

        return $this->_data;
    }


    /**
     * Converts config field names for magic getters
     *
     * @param string $name Method name
     * @return string
     */
    protected function _underscore($name)
    {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }

        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;
        return $result;
    }
}
