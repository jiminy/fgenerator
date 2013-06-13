<?php

namespace FixtureGenerator\Tests\Source;

use FixtureGenerator\Tests\TestCase;

class ArrayObject extends TestCase
{
    /**
     * @dataProvider addProvider
     */
    public function testConstruct($value)
    {
        $source = $this->getMock('\FixtureGenerator\Source\ArrayObject', array('createIterator'), array($value));
        $source->expects($this->once())->method('createIterator')->will($this->returnValue('FixtureGenerator\Source\Iterator'));
        $source->init();
        $this->assertInstanceOf('\FixtureGenerator\Source\ArrayObject', $source);
        $this->assertEquals('FixtureGenerator\Source\Iterator', $source->iterator);
    }

    public function addProvider()
    {
        return array(
            array(array('one', 2)),
            array(new \ArrayObject(array('one', 2)))
        );
    }

    public function testExtract()
    {
        $source = $this->getMock('\FixtureGenerator\Source\ArrayObject', array('createIterator'), array(array()));
        $iterator = $this->getMock('FixtureGenerator\Source\Iterator', array(), array(array()));
        $iterator->expects($this->exactly(2))->method('valid')->will($this->returnValue(true));
        $iterator->expects($this->exactly(2))->method('current')->will($this->onConsecutiveCalls(2, 'three'));
        $iterator->expects($this->exactly(2))->method('next');
        $source->iterator = $iterator;
        $this->assertEquals(2, $source->extract());
        $this->assertEquals('three', $source->extract());
    }
}