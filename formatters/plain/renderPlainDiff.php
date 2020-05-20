<?php

namespace Formatter;

function renderPlainDiff($tree)
{
//    var_dump($tree);
    $iter = function ($node) use (&$iter) {
        return array_reduce($node, function ($acc, $n) use (&$iter) {
            ['key' => $key, 'type' => $type, 'children' => $children] = $n;
            switch ($type) {
                case 'deleted':
                    $acc .= "Property '$key' was removed\n";
                    break;
                case 'edited':
                    $acc .= "Property '$key' was changed. From '{$n['oldValue']}' to '{$n['newValue']}'";
                    break;
                case 'added':
                    $acc .= "Property '$key' was added with value: ";
                    $acc .= stringify($n);
                    break;
                case 'nested':


            }
            return $acc;
        }, '');
    };

    return $iter($tree);
}

function stringify($n)
{
    if (!is_array($n)) {
        foreach ($n as $value) {
            return "'$value'";
        }
    }

    return "'complex value'";
}