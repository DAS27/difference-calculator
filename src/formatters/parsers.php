<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format = 'json')
{
    if ($format == 'yml') {
        $data = Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
        return json_decode(json_encode($data), true);
    }

    return json_decode($content, true);
}
