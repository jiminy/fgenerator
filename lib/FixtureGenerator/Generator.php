<?php

namespace FixtureGenerator;

abstract class Generator extends NamedComponent implements GeneratorInterface
{
    /**
     * @var CompositeGenerator a link to the parent generator
     */
    protected $_parent;

    /**
     * Sets a link to the parent
     *
     * @param Generator $generator
     * @return Generator
     */
    public function setParent(Generator $generator)
    {
        $this->_parent = $generator;

        return $this;
    }

    abstract public function generate();
}
