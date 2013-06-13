<?php

namespace FixtureGenerator\Tests;

use FixtureGenerator\Tests\data\ConcreteComponent;

class Component extends TestCase
{
    public function testSettingAndGettingWritableProtectedProperty()
    {
        $component = new ConcreteComponent;
        $component->init();
        $this->assertNull($component->property);
        $component->property = true;
        $this->assertTrue($component->property);
    }

    public function testGettingReadOnlyProperty()
    {
        $component = new ConcreteComponent;
        $component->init();
        $this->assertTrue($component->readOnly);
    }

    /**
     * @expectedException \FixtureGenerator\Exception
     */
    public function testExceptionOnSettingReadOnlyProperty()
    {
        $component = new ConcreteComponent;
        $component->readOnly = false;
    }

    /**
     * @expectedException \FixtureGenerator\Exception
     */
    public function testExceptionOnSettingUndefinedProperty()
    {
        $component = new ConcreteComponent;
        $component->undefined = true;
    }

    /**
     * @expectedException \FixtureGenerator\Exception
     */
    public function testExceptionOnGettingUndefinedProperty()
    {
        $component = new ConcreteComponent;
        $component->undefined;
    }

    /**
     * @dataProvider expressionProvider
     */
    public function testExpressionEvaluation($expression, $data, $result)
    {
        $component = new ConcreteComponent;
        $this->assertEquals($component->evaluate($expression, $data), $result);
    }

    public function expressionProvider()
    {
        return array(
            array('5', array(), 5),
            array('2*$row -$value', array('row' => 10, 'value' => 3), 17),
            array(function() {return 190;}, array(), 190),
            array(function($val) {return $val - 10;}, array('val' => 100), 90)
        );
    }
}