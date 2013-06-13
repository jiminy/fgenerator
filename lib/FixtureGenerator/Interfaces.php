<?php

namespace FixtureGenerator;

interface GeneratorInterface
{
    /**
     * Generates fixture data
     */
    public function generate();
}

interface ExporterInterface
{
    public function put($table, $row);

    public function escape($value);

    public function export($table);
}

interface SourceInterface
{
    public function extract();
}