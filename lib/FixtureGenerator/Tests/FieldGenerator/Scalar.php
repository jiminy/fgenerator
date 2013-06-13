<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\Tests\TestCase;

class Scalar extends TestCase
{
    public function testGenerate()
    {
        $scalar = new \FixtureGenerator\FieldGenerator\Scalar('name');
        $scalar->value = 100;
        $this->assertEquals(100, $scalar->generate());
    }
}