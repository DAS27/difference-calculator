<?php

namespace Ast;

use function Funct\Collection\union;

function mknode(string $key, string $type, array $children = [], $oldValue , $newValue) {
    return [
        'key' => $key,
        'type' => $type,
        'children' => $children,
        'oldValue' => $oldValue,
        'newValue' => $newValue
    ];
}

function buildDiff($arr1, $arr2)
{
    $keys = union(array_keys($arr1), array_keys($arr2));
    return array_map(function ($key) use ($arr1, $arr2) {
        if (!isset($arr1[$key])) {
            return mknode($key, 'added', [], null, $arr2[$key]);
        }
        if (!isset($arr2[$key])) {
            return mknode($key, 'deleted', [] , $arr1[$key], null);
        }
        if ($arr1[$key] !== $arr2[$key]) {
            return mknode($key, 'edited', [], $arr1[$key], $arr2[$key]);
        }
        if (is_array($arr1[$key]) && (is_array($arr2[$key]))) {
            return mknode($key, 'nested', buildDiff($arr1[$key], $arr2[$key]), null, null);
        }

        return mknode($key, 'unchanged', [], $arr1[$key], null);
    }, $keys);
}
