<?php

namespace Differ\Formatters;

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

function stringify($value)
{
    return is_array($value) ? "'complex value'" : "'{$value}'\n";
}
