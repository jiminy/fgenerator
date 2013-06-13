<?php

namespace FixtureGenerator;

class NamedComponent extends Component
{
    /**
     * @var string name of the component
     */
    protected $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }
}