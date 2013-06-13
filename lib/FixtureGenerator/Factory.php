<?php

namespace FixtureGenerator;

use OutOfRangeException;
use ReflectionClass;
use ReflectionProperty;
use UnexpectedValueException;

class Factory
{
    /**
     * @param $name
     * @param $options
     * @return Component
     * @throws Exception
     * @throws \UnexpectedValueException
     */
    public static function create($name, $options)
    {
        if (isset($options['class'])) {
            $class = $options['class'];
            unset($options['class']);
        } else
            throw new Exception("Class for component '$name' is not defined.");

        if (!class_exists($class))
            throw new UnexpectedValueException("Field generator $class doesn't exists.");

        /** @var $object Component */
        $object = new $class($name);

        foreach ($options as $name => $value) {
            $object->$name = $value;
        }

        $object->init();

        return $object;
    }

}
