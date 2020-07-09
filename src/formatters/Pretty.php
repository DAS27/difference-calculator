<?php

namespace Differ\Formatters\Pretty;

function renderPrettyDiff($tree)
{
    $iter = function ($node, $level = 1) use (&$iter) {
        return array_map(function ($item) use ($level, $iter) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $indent = str_repeat(' ', 4 * $level);
            $indentForChangedItems = str_repeat(' ', 4 * $level - 2);
            $formattedNewValue = stringify($newValue, $level);
            $formattedOldValue = stringify($oldValue, $level);
            switch ($type) {
                case 'nested':
                    $children = implode("\n", $iter($item['children'], $level + 1));
                    return "{$indent}{$key}: {\n{$children}\n{$indent}}";
                case 'added':
                    return "{$indentForChangedItems}+ {$key}: {$formattedNewValue}";
                case 'deleted':
                    return "{$indentForChangedItems}- {$key}: {$formattedOldValue}" ;
                case 'changed':
                    $result = [
                        "{$indentForChangedItems}+ {$key}: {$formattedNewValue}",
                        "{$indentForChangedItems}- {$key}: {$formattedOldValue}"
                    ];
                    return implode("\n", $result);
                case 'unchanged':
                    return "{$indent}{$key}: $formattedOldValue";
                default:
                    throw new \Exception("Undefined type: {$type}");
            }
        }, $node);
    };

    $result = implode("\n", $iter($tree));
    return "{\n{$result}\n}";
}

function stringify($value, $level = null)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (!is_array($value)) {
        return $value;
    }

    if (is_array($value)) {
        $indent = str_repeat(' ', 4 * $level);
        $dataIndent = str_repeat(' ', 4 * ($level + 1));
        $keys = array_keys($value);
        $makeStr = array_map(function ($key) use ($indent, $value, $dataIndent) {
            return "{$dataIndent}{$key}: {$value[$key]}";
        }, $keys);
        $result = implode(PHP_EOL, $makeStr);
        return "{\n{$result}\n{$indent}}";
    }
}
