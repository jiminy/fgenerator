<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\Tests\TestCase;

class Factory extends TestCase
{
    public function testCreateFieldGeneratorWithStringOptions()
    {
        $generator = \FixtureGenerator\FieldGenerator\Factory::create('name', 'scalar:100');
        $this->assertEquals(100, $generator->generate());
        $this->assertInstanceOf('FixtureGenerator\FieldGenerator\Scalar', $generator);
    }

    public function testCreateFieldGeneratorWithArrayOptions()
    {
        $generator = \FixtureGenerator\FieldGenerator\Factory::create('name', array(
            'type' => 'scalar',
            'value' => 100
        ));
        $this->assertEquals(100, $generator->generate());
        $this->assertInstanceOf('FixtureGenerator\FieldGenerator\Scalar', $generator);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testInvalidTypeException()
    {
        \FixtureGenerator\FieldGenerator\Factory::create('name', array(
            'wrongType'
        ));
    }
}