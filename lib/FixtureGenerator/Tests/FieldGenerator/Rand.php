<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\App;
use FixtureGenerator\Tests\TestCase;

class Rand extends TestCase
{
    public function testGenerateStringValue()
    {
        $generator = new \FixtureGenerator\FieldGenerator\Rand('name');
        $generator->value = '10,15';
        $generator->init();
        $this->assertThat($generator->generate(),
            $this->logicalAnd(
                $this->greaterThanOrEqual(10),
                $this->lessThanOrEqual(15)
            )
        );
    }

    public function testGenerateArrayValue()
    {
        $value = array('4');
        $generator = $this->getMock('\FixtureGenerator\FieldGenerator\Rand', array('addSource', 'getSource'), array('name'));
        $generator->expects($this->once())->method('addSource')->with($this->equalTo($value), $this->equalTo(array('iterator' => '\FixtureGenerator\Source\Iterator\Rand')));
        $source = $this->getMock('\FixtureGenerator\Source\ArrayObject', array('extract'), array($value));
        $source->expects($this->once())->method('extract')->will($this->returnValue(4));
        $generator->expects($this->once())->method('getSource')->with($value)->will($this->returnValue($source));
        $generator->value = $value;
        $generator->init();
        $this->assertEquals(4, $generator->generate());
    }

    public function testGenerateSource()
    {
        $value = 'source';
        $generator = $this->getMock('\FixtureGenerator\FieldGenerator\Rand', array('addSource', 'getSource'), array('name'));
        $generator->expects($this->once())->method('addSource');
        $source = $this->getMock('\FixtureGenerator\Source\File', array('extract'), array($value));
        $source->expects($this->once())->method('extract')->will($this->returnValue('one'));
        $generator->expects($this->once())->method('getSource')->with($value)->will($this->returnValue($source));
        $generator->source = $value;
        $generator->init();
        $this->assertEquals('one', $generator->generate());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testExceptionOnGenerateValue()
    {
        $generator = new \FixtureGenerator\FieldGenerator\Rand('name');
        $generator->value = true;
        $generator->generate();
    }

    /**
     * @expectedException \FixtureGenerator\Exception
     */
    public function testExceptionOnValueWithWrongFormat()
    {
        $generator = new \FixtureGenerator\FieldGenerator\Rand('name');
        $generator->value = 'integer';
        $generator->generate();
    }
}