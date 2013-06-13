<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\Tests\TestCase;

class Foreign extends TestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testGenerateException()
    {
        $foreign = new \FixtureGenerator\FieldGenerator\Foreign('name');
        $generator = $this->getMockForAbstractClass('FixtureGenerator\Generator', array('name'));
        $foreign->setParent($generator);
        $foreign->generate();
    }

    /**
     * @dataProvider generateProvider
     */
    public function testGenerate($value, $return)
    {
        $foreign = new \FixtureGenerator\FieldGenerator\Foreign('name');
        $generator = $this->getMock('FixtureGenerator\FieldGenerator\Relation', array('getForeign'), array('name'));
        $generator->expects(is_null($value) ? $this->once() : $this->never())->method('getForeign')->will($this->onConsecutiveCalls(2));
        $this->writeProperty($generator, '_rowNumber', 2);
        $foreign->setParent($generator);
        $foreign->value = $value;
        $this->assertEquals($return, $foreign->generate());
    }

    public function generateProvider()
    {
        return array(
            array(3, 3),
            array('$row*5', 10),
            array(function($row){return $row*4;}, 8),
            array(null, 2),
        );
    }
}