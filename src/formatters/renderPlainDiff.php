<?php

namespace Differ\Formatters;
/*
function renderPlainDiff($tree)
{
    $iter = function ($node, $ancestry = '') use (&$iter) {
        return array_reduce($node, function ($acc, $item) use ($iter, $ancestry) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $nestedPath = trim("{$ancestry}.{$key}", '.');
            $value = stringify($newValue);
            switch ($type) {
                case 'deleted':
                    $acc .= "Property '{$nestedPath}' was removed\n";
                    break;
                case 'added':
                    $acc .= "Property '{$nestedPath}' was added with value: ";
                    $acc .= stringify($newValue);
                    break;
                case 'edited':
                    $acc .= "\nProperty '{$nestedPath}' was changed. From '{$oldValue}' to '{$newValue}'\n";
                    break;
                case 'nested':
                    $acc .= $iter($item['children'], $key);
                    break;
            }
            return $acc;
        }, '');
    };

    return $iter($tree);
}
*/

use function Funct\Collection\flatten;

function renderPlainDiff($tree)
{
    $iter = function ($node, $ancestry = '') use (&$iter) {
        return array_map(function ($item) use ($iter, $ancestry) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $nestedPath = trim("{$ancestry}.{$key}", '.');
            switch ($type) {
                case 'deleted':
                    return "Property '{$nestedPath}' was removed";
                    break;
                case 'added':
                    return "Property '{$nestedPath}' was added with value: ";
                    break;
            }
        }, $node);
    };

    $flattened = flatten($iter($tree));

    return implode("\n", $flattened);
}

function stringify($value)
{
    return is_array($value) ? "'complex value'" : "'{$value}'";
}
