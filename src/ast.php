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
/*
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
        if (is_array($arr1[$key]) && is_array($arr2[$key])) {
            return mknode($key, 'nested', buildDiff($arr1[$key], $arr2[$key]), null, null);
        }
        if ($arr1[$key] !== $arr2[$key]) {
            return mknode($key, 'edited', [], $arr1[$key], $arr2[$key]);
        }

        return mknode($key, 'unchanged', [], $arr1[$key], null);
    }, $keys);
}
*/

function buildDiff($data1, $data2)
{
    $keys = union(array_keys($data1), array_keys($data2));
    return array_reduce($keys, function ($acc, $key) use ($data1, $data2) {
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] == $data2[$key]) {
                $acc[] = mknode($key, 'unchanged', [], $data1[$key], null);
                return  $acc;
            }
        }
        if (!array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            $acc[] = mknode($key, 'added', [],null, $data2[$key]);
            return $acc;
        }
        if (array_key_exists($key, $data1) && !array_key_exists($key, $data2)) {
            $acc[] = mknode($key, 'deleted', [], $data1[$key], null);
            return $acc;
        }
        if (is_array($data1[$key]) && is_array($data2[$key])) {
            $acc[] = mknode($key, 'nested', buildDiff($data1[$key], $data2[$key]), null, null);
            return  $acc;
        }
        if (array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            if ($data1[$key] !== $data2[$key]) {
                $acc[] = mknode($key, 'edited', [], $data1[$key], $data2[$key]);
                return $acc;
            }
        }

        return $acc;
    }, []);
}

/*
function buildDiff($arr1, $arr2)
{
    $keys = union(array_keys($arr1), array_keys($arr2));
    return array_map(function ($key) use ($arr1, $arr2) {
        if (!isset($arr1[$key])) {
            return [
                'name' => $key,
                'type' => 'added',
                'newValue' => $arr2[$key]
            ];
        }
        if (!isset($arr2[$key])) {
            return [
                'name' => $key,
                'type' => 'deleted',
                'oldValue' => $arr1[$key]
            ];
        }
        if (is_array($arr1[$key]) && is_array($arr2[$key])) {
            return [
                'name' => $key,
                'type' => 'nested',
                'children' => buildDiff($arr1[$key], $arr2[$key])
            ];
        }
        if ($arr1[$key] !== $arr2[$key]) {
            return [
                'name' => $key,
                'type' => 'edited',
                'oldValue' => $arr1[$key],
                'newValue' => $arr2[$key]
            ];
        }

        return [
            'name' => $key,
            'type' => 'unchanged',
            'oldValue' => $arr1[$key]
        ];
    }, $keys);
}
*/