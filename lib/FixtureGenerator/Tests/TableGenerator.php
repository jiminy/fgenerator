<?php

namespace FixtureGenerator\Tests;

class TableGenerator extends TestCase
{
    public function testInit()
    {
        $tg = $this->getMock('\FixtureGenerator\TableGenerator', array('createGenerator', 'setExporter'), array('name'));
        $generator = $this->getMockForAbstractClass('\FixtureGenerator\Generator', array('name'));
        $tg->expects($this->once())->method('createGenerator')->will($this->returnValue($generator));
        $tg->expects($this->once())->method('setExporter');
        $tg->fields = array('generator');
        $tg->init();
        $generators = $tg->getGenerators();
        $this->assertEquals($generator, $generators[0]);
    }

    public function testGetIntCount()
    {
        $tg = new \FixtureGenerator\TableGenerator('name');
        $tg->count = 3;
        $this->assertEquals(3, $this->invokeMethod($tg, 'getCount'));
    }

    public function testGetStringCount()
    {
        $tg = new \FixtureGenerator\TableGenerator('name');
        $tg->count = '2,4';
        $this->assertThat($this->invokeMethod($tg, 'getCount'),
            $this->logicalOr(
                $this->equalTo(2),
                $this->equalTo(3),
                $this->equalTo(4)
            )
        );
    }

    public function testGenerateWithEscape()
    {
        $tg = $this->getMock('\FixtureGenerator\TableGenerator', array('getExporter'), array('name'));
        $exporter = $this->getMock('\FixtureGenerator\Exporter\Csv', array('escape', 'put'));
        $exporter->expects($this->once())->method('escape')->with($this->equalTo('va"lue'))->will($this->returnValue('va\"lue'));
        $exporter->expects($this->once())->method('put')->with($this->equalTo(array('va\"lue')));
        $tg->expects($this->exactly(2))->method('getExporter')->will($this->returnValue($exporter));
        $generator = $this->getMock('\FixtureGenerator\FieldGenerator', array('generate'), array('name'));
        $generator->expects($this->once())->method('generate')->will($this->returnValue('va"lue'));
        $generator->escape = true;
        $tg->addGenerator($generator);
        $tg->count = 1;
        $tg->generate();
    }

    public function testGenerateWithoutEscape()
    {
        $tg = $this->getMock('\FixtureGenerator\TableGenerator', array('getExporter'), array('name'));
        $exporter = $this->getMock('\FixtureGenerator\Exporter\Csv', array('escape', 'put'));
        $exporter->expects($this->never())->method('escape');
        $exporter->expects($this->once())->method('put')->with($this->equalTo(array('va"lue')));
        $tg->expects($this->once())->method('getExporter')->will($this->returnValue($exporter));
        $generator = $this->getMock('\FixtureGenerator\FieldGenerator', array('generate'), array('name'));
        $generator->expects($this->once())->method('generate')->will($this->returnValue('va"lue'));
        $generator->escape = false;
        $tg->addGenerator($generator);
        $tg->count = 1;
        $tg->generate();
    }

    public function testGenerateRelation()
    {
        $tg = $this->getMock('\FixtureGenerator\TableGenerator', array('getExporter'), array('name'));
        $tg->expects($this->never())->method('getExporter');
        $generator = $this->getMock('\FixtureGenerator\FieldGenerator\Relation', array('generate'), array('name'));
        $generator->expects($this->once())->method('generate')->will($this->returnValue('va"lue'));
        $tg->addGenerator($generator);
        $tg->count = 1;
        $tg->generate();
    }
}