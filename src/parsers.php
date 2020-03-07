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

    $dataToArray1 = json_decode(json_encode($data1), true);
    $dataToArray2 = json_decode(json_encode($data2), true);

    $keys1 = array_keys($dataToArray1);
    $keys2 = array_keys($dataToArray2);
    $keys = union($keys1, $keys2);

    return array_reduce(
        $keys,
        function ($acc, $key) use ($dataToArray1, $dataToArray2) {
            if (array_key_exists($key, $dataToArray1) && array_key_exists($key, $dataToArray2)) {
                if ($dataToArray1[$key] === $dataToArray2[$key]) {
                    $result = "{$key}: {$dataToArray2[$key]}\n";
                } else {
                    $result = "+ {$key}: {$dataToArray2[$key]}\n";
                    $result .= "- {$key}: {$dataToArray1[$key]}\n";
                }
            } elseif (array_key_exists($key, $dataToArray1) && !array_key_exists($key, $dataToArray2)) {
                $result = "- {$key}: {$dataToArray1[$key]}\n";
            } else {
                $result = "+ {$key}: true\n";
            }
            $acc .= $result;
            return $acc;
        },
        ''
    );
}
