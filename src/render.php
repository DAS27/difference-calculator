<?php

namespace Renderer;

function render($tree)
{
    $iter = function ($node) use (&$iter) {
        return array_reduce($node, function ($acc, $n) use ($iter, $node) {
//            print_r($n);
            ['key' => $key, 'type' => $type, 'children' => $children] = $n;
//            $indent = str_repeat(' ', 4 * 1);
            switch ($type) {
                case 'unchanged':
                    $acc .= "  {$key}: ";
                    $acc .= stringify($n['oldValue']);
                    break;
                case 'deleted':
                    $acc .= "- {$key}: ";
                    $acc .= stringify($n['oldValue']);
                    break;
                case 'added':
                    $acc .= "+ {$key}: ";
                    $acc .= stringify($n['newValue']);
                    break;
                case 'edited':
                    $acc .= "+ {$key}: ";
                    $acc .= stringify($n['newValue']);
                    $acc .= "- {$key}: ";
                    $acc .= stringify($n['oldValue']);
                    break;
                case 'nested':
                    $acc .= "  {$key}: ";
                    $acc .= $iter($children);
                    $acc .= "  }\n";
                    break;
            }
            return $acc;
        }, "{\n");
    };

    return $iter($tree);
}

function stringify($n)
{
    $result = '';
    $level = 0;
    if (is_array($n)) {
        $result .= "{\n";
        $level++;
        $indent = str_repeat(' ', 4 * $level);
        foreach ($n as $key => $value) {
            $result .= $indent;
            $result .= "{$key}: {$value}\n";
        }
        $result .= "  }\n";
        return $result;
    }
    $result .= "{$n}\n";
    return $result;
}