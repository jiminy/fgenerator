<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\Tests\TestCase;

class Source extends TestCase
{
    public function testInit()
    {
        $array = array('empty');
        $field = $this->getMock('\FixtureGenerator\FieldGenerator\Source', array('addSource'), array('name'));
        $field->expects($this->once())->method('addSource')->with($this->equalTo($array), $this->equalTo(array('iterator' => '\FixtureGenerator\Source\Iterator')));
        $field->source = $array;
        $field->init();
    }

    public function testInitWithCustomIterator()
    {
        $value = 'value';
        $field = $this->getMock('\FixtureGenerator\FieldGenerator\Source', array('addSource'), array('name'));
        $field->expects($this->once())->method('addSource')->with($this->equalTo($value), $this->equalTo(array('iterator' => '\Iterator')));
        $field->source = array('value' => $value, 'iterator' => '\Iterator');
        $field->init();
    }

    public function testInitWithArrayValue()
    {
        $value = 'value';
        $field = $this->getMock('\FixtureGenerator\FieldGenerator\Source', array('addSource'), array('name'));
        $field->expects($this->once())->method('addSource')->with($this->equalTo($value), $this->equalTo(array('iterator' => '\FixtureGenerator\Source\Iterator')));
        $field->source = array('value' => $value);
        $field->init();
    }

    public function testGenerate()
    {
        $array = array('one', 2);
        $field = $this->getMock('\FixtureGenerator\FieldGenerator\Source', array('addSource', 'getSource'), array('name'));
        $field->expects($this->once())->method('addSource')->with($this->equalTo($array));
        $source = $this->getMock('FixtureGenerator\Source\ArrayObject', array('extract'), array($array));
        $source->expects($this->exactly(5))->method('extract')->will($this->onConsecutiveCalls('one', 2, 'one', 2, 'one'));
        $field->expects($this->exactly(5))->method('getSource')->with($this->equalTo($array))->will($this->returnValue($source));
        $field->source = $array;
        $field->init();
        for ($i=0;$i<5;$i++) {
            $this->assertEquals($i%2==0 ? 'one' : 2, $field->generate());
        }
    }
}