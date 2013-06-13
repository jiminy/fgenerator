<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\FieldGenerator;

class Scalar extends FieldGenerator
{
    public function generate()
    {
        return $this->value;
    }
}
