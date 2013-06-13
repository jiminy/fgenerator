<?php

namespace FixtureGenerator\Source;

use FixtureGenerator\Component;

class Iterator extends Component implements \Iterator
{
    protected $_array = array();

    protected $_keys = array();

    protected $_key = 0;

    function __construct(&$array)
    {
        $this->_array = & $array;
        $this->_keys = array_keys($array);
        $this->_key = reset($this->_keys);
    }

    public function current()
    {
        return $this->_array[$this->_key];
    }

    public function key()
    {
        return $this->_key;
    }

    /**
     * Move forward to next element
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_key = next($this->_keys);
    }

    /**
     * Rewind the Iterator to the first element
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_key = reset($this->_keys);
    }

    /**
     * Checks if current position is valid
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->_key !== false;
    }
}