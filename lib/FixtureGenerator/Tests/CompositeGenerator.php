<?php

namespace FixtureGenerator\Tests;

class CompositeGenerator extends TestCase
{
    public function testInit()
    {
        $compositeGenerator = $this->getMockBuilder('FixtureGenerator\CompositeGenerator')
            ->setConstructorArgs(array('name'))
            ->setMethods(array('setExporter'))
            ->getMockForAbstractClass();
        $compositeGenerator->expects($this->any())->method('setExporter');
        $compositeGenerator->init();
    }

    public function testGenerate()
    {
        $compositeGenerator = $this->getMockForAbstractClass('FixtureGenerator\CompositeGenerator', array('name1'));
        $this->assertInstanceOf('FixtureGenerator\CompositeGenerator', $compositeGenerator);
        $generator = $this->getMockForAbstractClass('FixtureGenerator\CompositeGenerator', array('name2'), '', true, true, true, array('generate'));
        $this->assertInstanceOf('FixtureGenerator\CompositeGenerator', $generator);
        $generator->expects($this->once())->method('generate');
        $compositeGenerator->addGenerator($generator);
        $compositeGenerator->generate();
    }

    public function testGeneratorsExport()
    {
        $compositeGenerator = $this->getMockForAbstractClass('FixtureGenerator\CompositeGenerator', array('name1'));
        $this->assertInstanceOf('FixtureGenerator\CompositeGenerator', $compositeGenerator);
        $generator = $this->getMockForAbstractClass('FixtureGenerator\CompositeGenerator', array('name2'), '', true, true, true, array('export'));
        $this->assertInstanceOf('FixtureGenerator\CompositeGenerator', $generator);
        $generator->expects($this->once())->method('export');
        $compositeGenerator->addGenerator($generator);
        $compositeGenerator->export();
    }

    public function testExporterExport()
    {
        $compositeGenerator = $this->getMockForAbstractClass('FixtureGenerator\CompositeGenerator', array('name'));
        $this->assertInstanceOf('FixtureGenerator\CompositeGenerator', $compositeGenerator);
        $exporter = $this->getMockForAbstractClass('FixtureGenerator\Exporter', array(), '', true, true, true, array('export'));
        $this->assertInstanceOf('FixtureGenerator\Exporter', $exporter);
        $exporter->expects($this->once())->method('export');
        $this->writeProperty($compositeGenerator, '_exporter', $exporter);
        $compositeGenerator->export();
    }
}