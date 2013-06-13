<?php

namespace FixtureGenerator\FieldGenerator;

use FixtureGenerator\FieldGenerator;

class Source extends FieldGenerator
{
    public $source;

    public function init()
    {
        parent::init();
        if (is_array($this->source) && isset($this->source['value'])) {
            $options = $this->source;
            unset($options['value']);
            $this->source = $this->source['value'];
        } else
            $options = array();
        if (!isset($options['iterator']))
            $options['iterator'] = '\FixtureGenerator\Source\Iterator';

        $this->addSource($this->source, $options);
    }

    public function generate()
    {
        $source = $this->getSource($this->source);
        return $source->extract();
    }

    protected function addSource($source, $options = array())
    {
        \FixtureGenerator\Source::storage()->add($source, $options);
    }

    protected function getSource($source)
    {
        return \FixtureGenerator\Source::storage()->get($source);
    }
}
