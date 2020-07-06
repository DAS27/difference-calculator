<?php

namespace Differ\Formatters\RenderPrettyDiff;

function renderPrettyDiff($tree)
{
    $iter = function ($node, $level = 1) use (&$iter) {
        return array_map(function ($item) use ($level, $iter) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $indent = str_repeat(' ', 4 * $level);
            $indentForChangedItems = str_repeat(' ', 4 * $level - 2);
            switch ($type) {
                case 'nested':
                    $children = implode("\n", $iter($item['children'], $level + 1));
                    return "{$indent}{$key}: {\n{$children}\n{$indent}}";
                case 'added':
                    return "{$indentForChangedItems}+ {$key}:" . stringify($newValue, $level);
                case 'deleted':
                    return "{$indentForChangedItems}- {$key}:" . stringify($oldValue, $level);
                case 'changed':
                    $result = [
                        "{$indentForChangedItems}+ {$key}:" . stringify($newValue, $level),
                        "{$indentForChangedItems}- {$key}:" . stringify($oldValue, $level)
                    ];
                    return implode("\n", $result);
                case 'unchanged':
                    return "{$indent}{$key}:" . stringify($oldValue, $level);
                default:
                    throw new \Exception("Undefined type: {$type}");
            }
        }, $node);
    };

    $result = implode("\n", $iter($tree));
    return "{\n{$result}\n}";
}

function stringify($value, $level)
{
    $indent = str_repeat(' ', 4 * $level);
    if (is_array($value)) {
        $level++;
        $indent2 = str_repeat(' ', 4 * $level);
        foreach ($value as $key => $item) {
            return " {\n{$indent2}{$key}: $item\n{$indent}}";
        }
    }

    if (is_bool($value)) {
        return $value ? " true" : " false";
    }

    return " {$value}";
}
