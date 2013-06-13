<?php

namespace FixtureGenerator;

use FixtureGenerator\Source\Iterator;

class Source extends Component
{
    /**
     * @var Source instance
     */
    protected static $_instance;

    /**
     * @var array Sources
     */
    protected $_sources = array();

    public static function storage()
    {
        if (is_null(self::$_instance))
            self::$_instance = new self;
        return self::$_instance;
    }

    private function __construct()
    {
    }

    public function generateSourceName($value)
    {
        return md5(serialize($value));
    }

    public function add($value, $options = array())
    {
        if (empty($options['class'])) {
            if (is_string($value))
                $options['class'] = 'FixtureGenerator\Source\File';
            elseif (is_array($value) || $value instanceof \ArrayAccess)
                $options['class'] = 'FixtureGenerator\Source\ArrayObject';
        }
        $source = $this->createSource($value, $options);
        $this->_sources[$this->generateSourceName($value)] = $source;
    }

    /**
     * @param $name
     * @return SourceInterface
     * @throws \OutOfRangeException
     */
    public function get($name)
    {
        $name = self::generateSourceName($name);
        if (!isset($this->_sources[$name]))
            throw new \OutOfRangeException("Class doesn't contain source with name $name");

        return $this->_sources[$name];
    }

    public function clear()
    {
        $this->_sources = array();
    }

    protected function createSource($value, $options)
    {
        return Factory::create($value, $options);
    }
}