<?php

namespace Formatter;

function renderPlainDiff($tree)
{
    $iter = function ($node, $path = '') use (&$iter) {
        return array_reduce($node, function ($acc, $n) use ($iter, $path) {
            ['key' => $key, 'type' => $type, 'children' => $children] = $n;
            $nestedPath = "{$path}.{$key}";
            switch ($type) {
                case 'deleted':
                    $acc .= "Property" . " " . "'" . trim($nestedPath, '.') . "'" . " " . "was removed\n";
                    break;
                case 'added':
                    $acc .= "Property" . " " . "'" . trim($nestedPath, '.') . "'" . " " . "was added with value: " . stringify($n['newValue']);
                    break;
                case 'edited':
                    $acc .= "\nProperty" . " " . "'" . trim($nestedPath, '.') . "'" . " " . "was changed. From '{$n['oldValue']}' to '{$n['newValue']}'\n";
                    break;
                case 'nested':
                    $acc .= $iter($children, $key);
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