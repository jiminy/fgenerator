<?php

namespace FixtureGenerator\Source;

use FixtureGenerator\App;
use FixtureGenerator\Exception;
use FixtureGenerator\Source;

class File extends ArrayObject
{
    public function __construct($value)
    {
        $file = App::instance()->getSourcePath() . DIRECTORY_SEPARATOR . $value;
        if (file_exists($file))
            $array = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        else
            throw new Exception("File $file doesn't exists.");

        parent::__construct($array);
    }
}