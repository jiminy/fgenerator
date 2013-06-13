<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\TableGenerator;

/**
 * @property TableGenerator $_parent
 */
class Relation extends TableGenerator
{
    public function getForeign()
    {
        if ($this->foreign) {
            return $this->evaluate($this->foreign, array('row' => $this->getRowNumber()));
        } else {
            return $this->_parent->getRowNumber();
        }
    }
}
