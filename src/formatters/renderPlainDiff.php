<?php

namespace Differ\Formatters\RenderPlainDiff;

use Exception;

use function Funct\Collection\flatten;

function renderPlainDiff($tree)
{
    $iter = function ($node, $ancestry = '') use (&$iter) {
        $result = array_map(function ($item) use ($iter, $ancestry) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            $propertyName = "{$ancestry}{$key}";
            $newValue = stringify($newValue);
            $oldValue = stringify($oldValue);
            switch ($type) {
                case 'changed':
                    return "Property '{$propertyName}' was changed. From '{$oldValue}' to '{$newValue}'";
                case 'deleted':
                    return "Property '{$propertyName}' was removed";
                case 'added':
                    return "Property '{$propertyName}' was added with value: '{$newValue}'";
                case 'unchanged':
                    break;
                case 'nested':
                    return $iter($item['children'], "{$ancestry}{$key}.");
                default:
                    throw new Exception("Undefined type: {$type}");
            }
        }, $node);
         return array_filter($result, function ($item) {
            return $item !== null;
         });
    };

    $flattened = flatten($iter($tree));
    return implode("\n", $flattened);
}

function stringify($value)
{
    return is_array($value) ? "complex value" : "{$value}";
}
