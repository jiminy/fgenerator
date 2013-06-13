<?php

namespace FixtureGenerator;

use FixtureGenerator\Generator;

abstract class FieldGenerator extends Generator
{
    public $type;

    public $value;

    public $escape = true;
}
