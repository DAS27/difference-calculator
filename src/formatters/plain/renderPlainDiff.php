<?php

namespace Differ\Formatter;

function renderPlainDiff($tree)
{
    $iter = function ($node, $path = '') use (&$iter) {
        return array_reduce($node, function ($acc, $n) use ($iter, $path) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $n;
            $nestedPath = "{$path}.{$key}";
            switch ($type) {
                case 'deleted':
                    $acc .= "Property " . "'" . trim($nestedPath, '.') . "'" . " was removed\n";
                    break;
                case 'added':
                    $acc .= "Property " . "'" . trim($nestedPath, '.') . "'" . " was added with value: " . stringify($newValue);
                    break;
                case 'edited':
                    $acc .= "\nProperty " . "'" . trim($nestedPath, '.') . "'" . " was changed. From '{$oldValue}' to '{$newValue}'\n";
                    break;
                case 'nested':
                    $acc .= $iter($n['children'], $key);
                    break;
            }
            return $acc;
        }, '');
    };

    return $iter($tree);
}

function stringify($node)
{
    return is_array($node) ? "'complex value'" : "'{$node}'\n";
}