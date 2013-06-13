<?php

namespace FixtureGenerator\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Calls protected/private method of a class.
     *
     * @param object $object     Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        $value = $method->invokeArgs($object, $parameters);
        $method->setAccessible(false);

        return $value;
    }

    /**
     * Returns value of protected/private property of a class.
     *
     * @param object $object       Instantiated object that we will run method on.
     * @param string $propertyName Property name to read
     *
     * @return mixed Property value.
     */
    public function readProperty($object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $value = $property->getValue($object);
        $property->setAccessible(false);

        return $value;
    }

    /**
     * Returns value of protected/private property of a class.
     *
     * @param object $object       Instantiated object that we will run method on.
     * @param string $propertyName Property name to read
     * @param mixed  $value        Value to be set
     */
    public function writeProperty($object, $propertyName, $value)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
        $property->setAccessible(false);
    }
}