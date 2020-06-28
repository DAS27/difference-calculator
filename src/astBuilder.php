<?php

namespace Differ\AstBuilder;

use function Funct\Collection\union;

function makeNode(string $key, string $type, $oldValue, $newValue, array $children = [])
{
    return [
        'key' => $key,
        'type' => $type,
        'oldValue' => $oldValue,
        'newValue' => $newValue,
        'children' => $children,
    ];
}

function buildDiff($data1, $data2)
{
    $keys = union(array_keys($data1), array_keys($data2));
    return array_reduce($keys, function ($acc, $key) use ($data1, $data2) {
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] == $data2[$key]) {
                $acc[] = makeNode($key, 'unchanged', $data1[$key], null);
                return  $acc;
            }
        }
        if (!array_key_exists($key, $data1)) {
            $acc[] = makeNode($key, 'added', null, $data2[$key]);
            return $acc;
        }
        if (!array_key_exists($key, $data2)) {
            $acc[] = makeNode($key, 'deleted', $data1[$key], null);
            return $acc;
        }
        if (is_array($data1[$key]) && is_array($data2[$key])) {
            $acc[] = makeNode($key, 'nested', null, null, buildDiff($data1[$key], $data2[$key]));
            return  $acc;
        }
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] !== $data2[$key]) {
                $acc[] = makeNode($key, 'edited', $data1[$key], $data2[$key]);
                return $acc;
            }
        }

        return $acc;
    }, []);
}
