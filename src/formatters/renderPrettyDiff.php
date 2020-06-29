<?php

namespace Differ\Renderer;

function render($tree)
{
    $operators = [
        'plus' => '+',
        'minus' => '-',
        'space' => "  ",
    ];

    $iter = function ($node, $level = 1) use (&$iter, $operators) {
        return array_reduce($node, function ($acc, $item) use ($operators, $iter, $level) {
            ['key' => $key, 'type' => $type, 'oldValue' => $oldValue, 'newValue' => $newValue] = $item;
            ['plus' => $plus, 'minus' => $minus, 'space' => $space] = $operators;
            $indent = str_repeat(' ', 2 * $level);
            switch ($type) {
                case 'unchanged':
                    $acc .= "{$indent}{$space}{$key}: ";
                    if (is_array($oldValue)) {
                        $acc .= str_replace('"', null, stringify($oldValue, $indent));
                    } else {
                        $acc .= str_replace('"', null, isBool($oldValue));
                    }
                    break;
                case 'deleted':
                    $acc .= "{$indent}{$minus} {$key}: ";
                    if (is_array($oldValue)) {
                        $acc .= str_replace('"', null, stringify($oldValue, $indent));
                    } else {
                        $acc .= str_replace('"', null, isBool($oldValue));
                    }
                    break;
                case 'added':
                    $acc .= "{$indent}{$plus} {$key}: ";
                    if (is_array($newValue)) {
                        $acc .= str_replace('"', null, stringify($newValue, $indent));
                    } else {
                        $acc .= str_replace('"', null, isBool($newValue));
                    }
                    break;
                case 'edited':
                    $acc .= "{$indent}{$plus} {$key}: ";
                    if (is_array($newValue)) {
                        $acc .= str_replace('"', null, stringify($newValue, $indent));
                    } else {
                        $acc .= str_replace('"', null, isBool($newValue));
                    }
                    $acc .= "{$indent}{$minus} {$key}: ";
                    if (is_array($oldValue)) {
                        $acc .= str_replace('"', null, stringify($oldValue, $indent));
                    } else {
                        $acc .= str_replace('"', null, isBool($oldValue));
                    }
                    break;
                case 'nested':
                    $acc .= "{$indent}{$space}{$key}: ";
                    $acc .= $iter($item['children'], 3);
                    $acc .= "{$indent}{$indent}}\n";
                    break;
            }
            return $acc;
        }, "{\n");
    };

    $result = $iter($tree);
    $result .= '}';
    return $result;
}

function stringify($node, $indent)
{
    $result = "";
    if (is_array($node)) {
        $result .= "{\n";
        foreach ($node as $key => $value) {
            $indent2 = str_repeat(" ", 6);
            $result .= "{$indent}{$indent2}\"$key: $value\"\n";
        }
        $result .= "  {$indent}}\n";
        return $result;
    }

    return $result;
}

function isBool($value)
{
    if (is_bool($value)) {
        return "\"true\"\n";
    }
    return "\"$value\"\n";
}
