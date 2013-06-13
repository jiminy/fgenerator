<?php

namespace FixtureGenerator\Tests;

class Exporter extends TestCase
{
    public function testInitialization()
    {
        $exporter = $this->getMockForAbstractClass('\FixtureGenerator\Exporter');
        $this->assertNull($this->readProperty($exporter, '_handle'));
        $exporter->init();
        $this->assertTrue(is_resource($this->readProperty($exporter, '_handle')));
        $this->assertContains("php://memory", stream_get_meta_data($this->readProperty($exporter, '_handle')));
    }

    public function testExport()
    {
        $exporter = $this->getMockForAbstractClass('\FixtureGenerator\Exporter');
        $handle = fopen("php://memory", 'w+');
        fwrite($handle, 'string');
        $this->writeProperty($exporter, '_handle', $handle);
        ob_start();
        $exporter->export();
        $string = ob_get_clean();
        $this->assertEquals('string', $string);
    }

    public function testEscape()
    {
        $exporter = $this->getMockForAbstractClass('\FixtureGenerator\Exporter');
        $this->assertEquals('string', $exporter->escape('string'));
    }
}