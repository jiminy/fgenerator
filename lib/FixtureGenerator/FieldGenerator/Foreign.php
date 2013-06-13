<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\FieldGenerator;

/**
 * @property Relation $_parent
 */
class Foreign extends FieldGenerator
{
    public function generate()
    {
        if (!$this->_parent instanceof Relation)
            throw new \LogicException("Parent table is not Relation.");

        if (is_int($this->value))
            return $this->value;
        elseif (is_string($this->value) || $this->value instanceof \Closure)
            return $this->evaluate($this->value, array('row' => $this->_parent->getRowNumber()));
        else
            return $this->_parent->getForeign();
    }
}
