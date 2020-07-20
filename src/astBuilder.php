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
    $keys1 = collect($data1)->keys()->all();
    $keys2 = collect($data2)->keys()->all();
    $keys = union($keys1, $keys2);
    return array_map(function ($key) use ($data1, $data2) {
        if (!property_exists($data1, $key)) {
            return makeNode($key, 'added', null, $data2->$key);
        }
        if (!property_exists($data2, $key)) {
            return makeNode($key, 'deleted', $data1->$key, null);
        }
        if (is_object($data1->$key) && is_object($data2->$key)) {
            return makeNode($key, 'nested', null, null, buildDiff($data1->$key, $data2->$key));
        }
        if ($data1->$key == $data2->$key) {
            return makeNode($key, 'unchanged', $data1->$key, null);
        }
        return makeNode($key, 'changed', $data1->$key, $data2->$key);
    }, $keys);
}
