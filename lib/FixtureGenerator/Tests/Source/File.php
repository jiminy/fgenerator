<?php

namespace FixtureGenerator\Tests\Source;

use FixtureGenerator;
use FixtureGenerator\Tests\TestCase;

class File extends TestCase
{
    public function testConstruct()
    {
        $source = $this->getMock('FixtureGenerator\Source\File', array('createIterator'), array('source'));
        $source->expects($this->once())->method('createIterator')->will($this->returnArgument(0));
        $source->init();
        $this->assertContains('one', $source->iterator);
        $this->assertContains(2, $source->iterator);
    }

    /**
     * @expectedException FixtureGenerator\Exception
     */
    public function testException()
    {
        new FixtureGenerator\Source\File('file');
    }
}