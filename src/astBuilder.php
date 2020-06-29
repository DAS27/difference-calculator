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
    return array_map(function ($key) use ($data1, $data2) {
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] == $data2[$key]) {
                return makeNode($key, 'unchanged', $data1[$key], null);
            }
        }
        if (!array_key_exists($key, $data1)) {
            return makeNode($key, 'added', null, $data2[$key]);
        }
        if (!array_key_exists($key, $data2)) {
            return makeNode($key, 'deleted', $data1[$key], null);
        }
        if (is_array($data1[$key]) && is_array($data2[$key])) {
            return makeNode($key, 'nested', null, null, buildDiff($data1[$key], $data2[$key]));
        }
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] !== $data2[$key]) {
                return makeNode($key, 'edited', $data1[$key], $data2[$key]);
            }
        }
    }, $keys);
}
