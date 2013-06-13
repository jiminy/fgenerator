<?php

namespace FixtureGenerator\Tests\FieldGenerator;

use FixtureGenerator\Tests\TestCase;

class Relation extends TestCase
{
    public function testGetForeignRowNumber()
    {
        $relation = new \FixtureGenerator\FieldGenerator\Relation('name');
        $generator = new \FixtureGenerator\TableGenerator('name');
        $relation->setParent($generator);
        $this->assertEquals(1, $relation->getForeign());
        $this->writeProperty($generator, '_rowNumber', 3);
        $this->assertEquals(3, $relation->getForeign());
    }

    /**
     * @dataProvider foreignProvider
     */
    public function testGetForeignFromProperty($foreign)
    {
        $relation = new \FixtureGenerator\FieldGenerator\Relation('name');
        $relation->foreign = $foreign;
        $this->assertEquals(2, $relation->getForeign());
        $this->writeProperty($relation, '_rowNumber', 3);
        $this->assertEquals(6, $relation->getForeign());
    }

    public function foreignProvider()
    {
        return array(
            array(function ($row) {
                return $row * 2;
            }),
            array('$row * 2'),
        );
    }
}