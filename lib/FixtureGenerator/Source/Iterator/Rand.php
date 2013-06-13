<?php

namespace FixtureGenerator\Source\Iterator;

use FixtureGenerator\Source\Iterator;

class Rand extends Iterator
{
    public function __construct($array)
    {
        parent::__construct($array);
        $this->_next();
    }

    public function next()
    {
        $this->_next();
    }

    protected function _next()
    {
        $this->_key = array_rand($this->_array);
    }
}