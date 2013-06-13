<?php

namespace FixtureGenerator;

class DbGenerator extends CompositeGenerator
{
    public $tables = array();

    public function init()
    {
        foreach ($this->tables as $table => $options) {
            if (empty($options['class']))
                $options['class'] = '\FixtureGenerator\TableGenerator';
            $generator = $this->createTableGenerator($table, $options);
            $this->addGenerator($generator);
        }
    }

    protected function createTableGenerator($name, $options)
    {
        return Factory::create($name, $options);
    }
}
