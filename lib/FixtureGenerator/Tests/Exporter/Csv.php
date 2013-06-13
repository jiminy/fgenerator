<?php

namespace FixtureGenerator\Tests\Exporter;

use FixtureGenerator\Tests\TestCase;

class Csv extends TestCase
{
    public function testExportNotEscaped()
    {
        $csv = new \FixtureGenerator\Exporter\Csv('name');
        $csv->init();
        $csv->put(array(1, 'two', '"three"'));
        ob_start();
        $csv->export();
        $string = ob_get_clean();
        $this->assertEquals('1;two;"three"' ."\n", $string);
    }

    public function testExportEscaped()
    {
        $csv = new \FixtureGenerator\Exporter\Csv('name');
        $csv->init();
        $array = array(1, 'two', '"three"');
        $array = array_map(array($csv, 'escape'), $array);
        $csv->put($array);
        ob_start();
        $csv->export();
        $string = ob_get_clean();
        $this->assertEquals('"1";"two";"\"three\""' . "\n", $string);
    }
}