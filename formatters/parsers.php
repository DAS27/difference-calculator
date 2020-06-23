<?php

namespace Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($path, $format = 'json')
{
    $data = file_get_contents($path);

    if ($format == 'yml') {
        $data = Yaml::parseFile($path, Yaml::PARSE_OBJECT_FOR_MAP);
        return json_decode(json_encode($data), true);
    }

    return json_decode($data, true);
}
