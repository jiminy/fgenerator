<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\Exception;

class Factory extends \FixtureGenerator\Factory
{
    public static $classes = array(
        'ai' => 'FixtureGenerator\FieldGenerator\Ai',
        'expr' => 'FixtureGenerator\FieldGenerator\Expression',
        'foreign' => 'FixtureGenerator\FieldGenerator\Foreign',
        'rand' => 'FixtureGenerator\FieldGenerator\Rand',
        'relation' => 'FixtureGenerator\FieldGenerator\Relation',
        'scalar' => 'FixtureGenerator\FieldGenerator\Scalar',
        'source' => 'FixtureGenerator\FieldGenerator\Source',
    );

    /**
     * @param $name
     * @param $options
     * @return \FixtureGenerator\FieldGenerator
     * @throws \FixtureGenerator\Exception
     * @throws \OutOfRangeException
     */
    public static function create($name, $options)
    {
        if (is_string($options)) {
            if (!preg_match('/^(?P<type>\w+)(?::(?P<value>[^:]*))?(?::(?P<source>.*))?$/', $options, $matches))
                throw new Exception('Options must be specified in the format of "type:value:source".');
            $options = array();
            array_walk($matches, function ($item, $key) use (&$options) {
                if (!is_numeric($key)) $options[$key] = $item;
            });
        }

        if (!isset($options['class'])) {
            if (isset($options['type']) && isset(self::$classes[$options['type']])) {
                $options['class'] = self::$classes[$options['type']];
                unset($options['type']);
            } else {
                throw new \OutOfRangeException('Type of generator is invalid.');
            }
        }

        return parent::create($name, $options);
    }
}