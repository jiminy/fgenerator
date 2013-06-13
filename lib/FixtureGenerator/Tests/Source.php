<?php

namespace FixtureGenerator\Tests;

class Source extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        \FixtureGenerator\Source::storage()->clear();
    }

    /**
     * @dataProvider addProvider
     */
    public function testAddSource($value, $expected)
    {
        $sourceClass = $this->getMock('\FixtureGenerator\Source', array('createSource'), array('name'), '', false);
        $sourceClass->expects($this->once())->method('createSource')->will($this->returnArgument(1));
        $sourceClass->add($value);
        $source = $sourceClass->get($value);
        $this->assertEquals($source, $expected);
    }

    public function addProvider()
    {
        return array(
            array(TEST_PATH . '/data/source', array('class' => 'FixtureGenerator\Source\File')),
            array(array('one', 'two'), array('class' => 'FixtureGenerator\Source\ArrayObject')),
            array(new \ArrayObject(array('one', 'two')), array('class' => 'FixtureGenerator\Source\ArrayObject'))
        );
    }

    public function testAddCustomSource()
    {
        $class = '\ArrayIterator';
        $value = array();
        $sourceClass = $this->getMock('\FixtureGenerator\Source', array('createSource'), array('name'), '', false);
        $sourceClass->expects($this->once())->method('createSource')->will($this->returnArgument(1));
        $sourceClass->add($value, $class);
        $source = $sourceClass->get($value);
        $this->assertEquals($source, $class);
    }

    public function testStorageInit()
    {
        $storage = \FixtureGenerator\Source::storage();
        $this->assertInstanceOf('\FixtureGenerator\Source', $storage);
    }
}