<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\App;
use FixtureGenerator\Source;
use FixtureGenerator\TableGenerator;
use FixtureGenerator\Tests\TestCase;

class Expression extends TestCase
{
    public function testInitWithSource()
    {
        $expr = $this->getMock('\FixtureGenerator\FieldGenerator\Expression', array('addSource'), array('name'));
        $expr->expects($this->once())->method('addSource');
        $expr->source = 'source';
        $expr->init();
    }

    /**
     * @dataProvider generateProvider
     */
    public function testGenerateFromValue($value, $return)
    {
        $expr = new \FixtureGenerator\FieldGenerator\Expression('name');
        $generator = new TableGenerator('name');
        $this->writeProperty($generator, '_rowNumber', 2);
        $expr->setParent($generator);
        $expr->value = $value;
        $expr->init();
        $this->assertEquals($return, $expr->generate());
    }

    public function generateProvider()
    {
        return array(
            array('$row * 10', 20),
            array(function ($row) {return $row * 20;}, 40),
        );
    }

    /**
     * @dataProvider generateFromSourceProvider
     */
    public function testGenerateFromSource($value, $return1, $return2)
    {
        $expr = $this->getMock('\FixtureGenerator\FieldGenerator\Expression', array('addSource', 'getSource'), array('name'));
        $expr->expects($this->once())->method('addSource');
        $source = $this->getMock('\FixtureGenerator\Source\ArrayObject', array('extract'), array(), '', false);
        $source->expects($this->exactly(2))->method('extract')->will($this->onConsecutiveCalls(2,3));
        $expr->expects($this->exactly(2))->method('getSource')->will($this->returnValue($source));
        $generator = new TableGenerator('name');
        $this->writeProperty($generator, '_rowNumber', 3);
        $expr->setParent($generator);
        $expr->value = $value;
        $expr->source = array(2,3);
        $expr->init();
        $this->assertEquals($return1, $expr->generate());
        $this->assertEquals($return2, $expr->generate());
    }

    public function generateFromSourceProvider()
    {
        return array(
            array('$row * $value', 6, 9),
            array(function ($row, $value) {return $row * $value * 2;}, 12, 18),
        );
    }
}