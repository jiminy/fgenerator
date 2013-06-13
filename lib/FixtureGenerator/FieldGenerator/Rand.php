<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\Exception;
use FixtureGenerator\FieldGenerator;

class Rand extends Source
{
    public function init()
    {
        $options = array('iterator' => '\FixtureGenerator\Source\Iterator\Rand');
        if ($this->source)
            parent::init();
        elseif (is_array($this->value))
            $this->addSource($this->value, $options);
    }

    public function generate()
    {
        if ($this->source) {
            $value = $this->getSource($this->source)->extract();
        } else {
            if (is_string($this->value)) {
                $ranges = array_map('trim', explode(',', $this->value));
                if (sizeof($ranges) !== 2)
                    throw new Exception('Value must have format like "integer, integer".');
                $value = mt_rand($ranges[0], $ranges[1]);
            } elseif (is_array($this->value)) {
                $value = $this->getSource($this->value)->extract();
            } else
                throw new \UnexpectedValueException('Value must be string or array.');
        }
        return $value;
    }
}