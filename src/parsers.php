<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    switch ($format) {
        case 'json':
            return json_decode($content, true);
        case 'yml':
            return Yaml::parse($content);
        default:
            throw new \Error('Error format is wrong!');
    }
}
