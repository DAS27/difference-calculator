<?php

namespace Differ\Formatters;

use function Funct\Collection\flattenAll;

function renderPlainDiff($tree)
{
    $iter = function ($node, $ancestry = '') use (&$iter) {
        return array_map(function ($item) use ($iter, $ancestry) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $nestedPath = trim("{$ancestry}.{$key}", '.');
            $newValue = stringify($newValue);
            switch ($type) {
                case 'edited':
                    return "Property '{$nestedPath}' was changed. From '{$oldValue}' to '{$newValue}'";
                    break;
                case 'deleted':
                    return "Property '{$nestedPath}' was removed";
                    break;
                case 'added':
                    return "Property '{$nestedPath}' was added with value: '{$newValue}'";
                    break;
                default:
                    return $iter($item['children'], $key);
            }
        }, $node);
    };

    $flattened = flattenAll($iter($tree));

    return implode("\n", $flattened);
}

function stringify($value)
{
    return is_array($value) ? "complex value" : "{$value}";
}
