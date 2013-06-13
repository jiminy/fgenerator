<?php

namespace FixtureGenerator\Exporter;

use FixtureGenerator\Exporter;

class Csv extends Exporter
{
    public $fieldSeparator = ';';

    public $fieldEnclose = '"';

    public $fieldEscape = "\\";

    public $lineSeparator = "\n";

    public function put(array $row)
    {
        $row = $this->buildRow($row);
        fwrite($this->_handle, $row);
    }

    protected function buildRow(array $row)
    {
        return join($this->fieldSeparator, $row) . $this->lineSeparator;
    }

    public function escape($value)
    {
        $value = str_replace($this->fieldEnclose, $this->fieldEscape . $this->fieldEnclose, $value);
        $value = sprintf('%1$s%2$s%1$s', $this->fieldEnclose, $value);

        return $value;
    }
}
