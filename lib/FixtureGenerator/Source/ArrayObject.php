<?php

namespace FixtureGenerator\Source;

use FixtureGenerator\Component;
use FixtureGenerator\Factory;
use FixtureGenerator\Source;
use FixtureGenerator\SourceInterface;

class ArrayObject extends Component implements SourceInterface
{
    protected $_array = array();

    /**
     * @var Iterator
     */
    public $iterator;

    public function __construct($value)
    {
        if (!is_array($value) && !$value instanceof \ArrayAccess)
            throw new \InvalidArgumentException('Value must be an array.');
        $this->_array = $value;
    }

    public function init()
    {
        parent::init();

        if (!$this->iterator)
            $this->iterator = 'FixtureGenerator\Source\Iterator';

        if (!$this->iterator instanceof Iterator) {
            if (is_string($this->iterator))
                $this->iterator = array('class' => $this->iterator);
            $this->iterator = $this->createIterator($this->_array, $this->iterator);
        }
    }

    public function extract()
    {
        $iterator = $this->iterator;
        if (!$iterator->valid())
            $iterator->rewind();
        $value = $iterator->current();
        $iterator->next();
        return $value;
    }

    public function createIterator($value, $options)
    {
        return Factory::create($value, $options);
    }
}