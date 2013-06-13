<?php

namespace FixtureGenerator\Tests;

use FixtureGenerator\Exception;

class Factory extends TestCase
{
    /**
     * @expectedException \FixtureGenerator\Exception
     */
    public function testEmptyClassOptionException()
    {
        \FixtureGenerator\Factory::create('name', array());
    }

    public function testCreate()
    {
        $component = \FixtureGenerator\Factory::create('name', array(
            'class' => '\FixtureGenerator\Tests\data\ConcreteComponent',
            'property' => 5
        ));
        $this->assertEquals(5, $component->property);
    }
}