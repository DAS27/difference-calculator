<?php

namespace Formatter;
use function Renderer\stringify;
use function Renderer\isBool;

function renderJsonDiff($tree)
{
    $operators = [
        'plus' => '+',
        'minus' => '-',
        'space' => " ",
    ];

    $iter = function ($node, $level = 1) use (&$iter, $operators) {
        return array_reduce($node, function ($acc, $n) use ($operators, $iter, $level) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $n;
            ['plus' => $plus, 'minus' => $minus, 'space' => $space] = $operators;
            $indent = str_repeat(' ', 2 * $level);
            switch ($type) {
                case 'unchanged':
                    $acc .= "{$indent}\"$space $key\": ";
                    $acc .= is_array($oldValue) ? stringify($oldValue, $indent) : isBool($oldValue);
                    break;
                case 'deleted':
                    $acc .= "{$indent}\"$minus $key\": ";
                    $acc .= is_array($oldValue) ? stringify($oldValue, $indent) : isBool($oldValue);
                    break;
                case 'added':
                    $acc .= "{$indent}\"$plus $key\": ";
                    $acc .= is_array($newValue) ? stringify($newValue, $indent) : isBool($newValue);
                    break;
                case 'edited':
                    $acc .= "{$indent}\"$plus $key\": ";
                    $acc .= is_array($newValue) ? stringify($newValue, $indent) : isBool($newValue);
                    $acc .= "{$indent}\"$minus $key\": ";
                    $acc .= is_array($oldValue) ? stringify($oldValue, $indent) : isBool($oldValue);
                    break;
                case 'nested':
                    $acc .= "{$indent}\"$space $key\": ";
                    $acc .= $iter($n['children'], 3);
                    $acc .= "{$indent}{$indent}}\n";
                    break;
            }
            return $acc;
        }, "{\n");
    };

    $result = $iter($tree);
    $result .= "}";
    return $result;
}
