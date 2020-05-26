<?php

namespace Parsers;

use Symfony\Component\Yaml\Yaml;

use function Funct\Collection\union;

function genDiff($pathToFile1, $pathToFile2)
{
    $extension1 = pathinfo($pathToFile1);
    $extension2 = pathinfo($pathToFile2);

    if ($extension1['extension'] !== 'yml' && $extension2['extension'] !== 'yml') {
        return false;
    }

    $data1 = Yaml::parseFile($pathToFile1, Yaml::PARSE_OBJECT_FOR_MAP);
    $data2 = Yaml::parseFile($pathToFile2, Yaml::PARSE_OBJECT_FOR_MAP);

    $array1 = json_decode(json_encode($data1), true);
    $array2 = json_decode(json_encode($data2), true);

    $keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $keys = union($keys1, $keys2);

    return array_reduce(
        $keys,
        function ($acc, $key) use ($array1, $array2) {
            if (array_key_exists($key, $array1) && array_key_exists($key, $array2)) {
                if ($array1[$key] === $array2[$key]) {
                    $result = "{$key}: {$array2[$key]}\n";
                } else {
                    $result = "+ {$key}: {$array2[$key]}\n";
                    $result .= "- {$key}: {$array1[$key]}\n";
                }
            } elseif (array_key_exists($key, $array1) && !array_key_exists($key, $array2)) {
                $result = "- {$key}: {$array1[$key]}\n";
            } else {
                $result = "+ {$key}: true\n";
            }
            $acc .= $result;
            return $acc;
        },
        ''
    );
}
