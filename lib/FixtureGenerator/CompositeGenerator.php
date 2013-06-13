<?php

namespace FixtureGenerator;

abstract class CompositeGenerator extends Generator
{
    const DEFAULT_EXPORTER = '\FixtureGenerator\Exporter\Csv';

    /**
     * @var \FixtureGenerator\Exporter data exporter
     */
    protected $_exporter;

    /**
     * @var Generator[] array with children generators
     */
    protected $_generators = array();

    public function init()
    {
        if (!$this->_exporter){
            $this->setExporter(array('class' => self::DEFAULT_EXPORTER));
        }
    }

    /**
     * Adds new generator
     *
     * @param Generator $generator
     */
    public function addGenerator(Generator $generator)
    {
        $generator->setParent($this);
        $this->_generators[] = $generator;
    }

    public function getGenerators()
    {
        return $this->_generators;
    }

    public function setExporter($options = array())
    {
        if (isset($options['class'])) {
            $this->_exporter = new $options['class'];
            $this->_exporter->init();
        } else
            throw new Exception('Class is not specified.');
    }

    public function getExporter()
    {
        return $this->_exporter;
    }

    public function generate()
    {
        foreach ($this->_generators as $generator) {
            $generator->generate();
        }
    }

    /**
     * Exports generated data
     */
    public function export()
    {
        if (isset($this->_exporter))
            $this->_exporter->export($this->_name);
        foreach ($this->_generators as $generator) {
            if ($generator instanceof CompositeGenerator)
                $generator->export();
        }
    }
}
