<?php

namespace FixtureGenerator\Tests\Source\Iterator;

class Rand extends \PHPUnit_Framework_TestCase
{
    public function testIterate()
    {
        $array = array("Monday", "Tuesday", "Wednesday");
        $iterator = new \LimitIterator(new \FixtureGenerator\Source\Iterator\Rand($array), 0, 100);
        $i = 0;
        $values = array();
        foreach ($iterator as $key => $value) {
            $i++;
            $this->assertThat($key,
                $this->logicalOr(
                    $this->equalTo(0),
                    $this->equalTo(1),
                    $this->equalTo(2)
                )
            );
            $this->assertEquals($array[$key], $value);
            $values[] = $value;
        }
        $results = array_count_values($values);
        $this->assertLessThan(50, $results['Monday']);
    }
}