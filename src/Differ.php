<?php

namespace Differ;

use function Funct\Collection\union;

function genDiff($pathToFile1, $pathToFile2)
{
    $dataFromPath1 = file_get_contents($pathToFile1);
    $dataFromPath2 = file_get_contents($pathToFile2);

    $dataToArray1 = json_decode($dataFromPath1, true);
    $dataToArray2 = json_decode($dataFromPath2, true);

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
