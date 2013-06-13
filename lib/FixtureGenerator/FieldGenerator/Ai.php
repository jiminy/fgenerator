<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\FieldGenerator;

class Ai extends FieldGenerator
{
    public function generate()
    {
        return $this->_parent->getRowNumber();
    }
}