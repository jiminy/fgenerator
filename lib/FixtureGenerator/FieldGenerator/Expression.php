<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\FieldGenerator\Source;

/**
 * @property string|\Closure $value value
 */
class Expression extends Source
{
    public function init()
    {
        if ($this->source) {
            parent::init();
        }
    }

    public function generate()
    {
        if ($this->source)
            return $this->evaluate($this->value, array('row' => $this->_parent->getRowNumber(), 'value' => $this->getSource($this->source)->extract()));
        else
            return $this->evaluate($this->value, array('row' => $this->_parent->getRowNumber()));
    }
}
