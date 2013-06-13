<?php

namespace FixtureGenerator\Tests;

class DbGenerator extends TestCase
{
    public function testInit()
    {
        $dbGenerator = $this->getMock('FixtureGenerator\DbGenerator', array('createTableGenerator'), array('name'));
        $generator = $this->getMockForAbstractClass('FixtureGenerator\Generator', array('name'));
        $map = array(
            array('table_name', array('class' => '\FixtureGenerator\TableGenerator'), $generator)
        );
        $dbGenerator->expects($this->once())->method('createTableGenerator')->will($this->returnValueMap($map));
        $dbGenerator->tables = array('table_name' => array());
        $dbGenerator->init();
    }
}