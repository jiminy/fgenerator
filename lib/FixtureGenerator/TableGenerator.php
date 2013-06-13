<?php

namespace FixtureGenerator;

use Closure;
use FixtureGenerator\Exporter;
use FixtureGenerator\FieldGenerator;
use FixtureGenerator\FieldGenerator\Relation;

/**
 * @property int rowNumber
 * @property int count
 * @property string export
 * @property array fields
 * @property string|Closure $foreign
 * @property int offset
 */
class TableGenerator extends CompositeGenerator
{
    protected $_rowNumber = 1;

    public $count = 5;

    public $fields = array();

    public $foreign;

    public $offset = 1;

    public function getRowNumber()
    {
        return $this->_rowNumber;
    }

    public function init()
    {
        parent::init();
        foreach ($this->fields as $field => $options) {
            $generator = $this->createGenerator($field, $options);
            $this->addGenerator($generator);
        }
    }

    public function generate()
    {
        $count = $this->getCount();
        for ($this->_rowNumber, $this->offset = $this->_rowNumber; $this->_rowNumber < $count + $this->offset; $this->_rowNumber++) {
            $row = array();
            /* @var FieldGenerator $generator */
            foreach ($this->_generators as $generator) {
                if (isset($generator->escape) && $generator->escape)
                    $row[] = $this->getExporter()->escape($generator->generate());
                elseif (!$generator instanceof Relation)
                    $row[] = $generator->generate();
                else
                    $generator->generate();
            }
            if (!empty($row))
                $this->getExporter()->put($row);
        }
    }

    protected function getCount()
    {
        if (strpos($this->count, ',') !== false) {
            list($min, $max) = explode(',', $this->count);
            return mt_rand($min, $max);
        } else {
            return $this->count;
        }
    }

    protected function createGenerator($name, $options)
    {
        return FieldGenerator\Factory::create($name, $options);
    }
}
