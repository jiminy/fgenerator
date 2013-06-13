<?php

namespace FixtureGenerator\Tests\data;

use FixtureGenerator\Component;

/**
 * @property $property
 * @property $readOnly
 */
class ConcreteComponent extends Component
{
    protected $property;

    protected $readOnly;

    public function init()
    {
        $this->readOnly = true;
    }

    public function setProperty($value)
    {
        $this->property = $value;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function getReadOnly()
    {
        return $this->readOnly;
    }
}