<?php

namespace FixtureGenerator;

/**
 * @property int $maxmemory
 */
abstract class Exporter extends Component
{
    protected $_handle;

    public $filename = "php://memory";

    public function init()
    {
        $this->_handle = fopen($this->filename, 'w+');
    }

    public function export()
    {
        if ($this->_handle) {
            rewind($this->_handle);
            echo stream_get_contents($this->_handle);
        }
    }

    public function escape($value)
    {
        return $value;
    }

    abstract protected function buildRow(array $row);

    abstract public function put(array $row);
}