<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($data, $format)
{
    switch ($format) {
        case 'json':
            return json_decode($data, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data);
        default:
            throw new \Exception("Unknown format: {$format}");
    }
}
