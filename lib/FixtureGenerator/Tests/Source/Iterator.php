<?php

namespace FixtureGenerator\Tests\Source;

use FixtureGenerator\Tests\TestCase;

class Iterator extends TestCase
{
    public function testIterate()
    {
        $array = array('one' => 1, 'two', 'four' => 5, 7 => 10);
        $iterator = new \FixtureGenerator\Source\Iterator($array);
        foreach ($iterator as $k => $v) {
            list($key, $val) = each($array);
            $this->assertEquals($key, $k);
            $this->assertEquals($val, $v);
        }

    }
}