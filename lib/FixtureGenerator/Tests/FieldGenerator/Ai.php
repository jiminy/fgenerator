<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\TableGenerator;
use FixtureGenerator\Tests\TestCase;

class Ai extends TestCase
{
    public function testGenerate()
    {
        $generator = new \FixtureGenerator\FieldGenerator\Ai('ai');
        $compositeGenerator = new TableGenerator('table');
        $generator->setParent($compositeGenerator);
        for ($i = 1; $i <= 5; $i++) {
            $this->writeProperty($compositeGenerator, '_rowNumber', $i);
            $this->assertEquals($i, $generator->generate());
        }
    }
}