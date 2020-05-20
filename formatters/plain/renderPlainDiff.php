<?php

namespace Formatter;

function renderPlainDiff($tree)
{
    $iter = function ($node) use (&$iter) {
        return array_reduce($node, function ($acc, $n) use (&$iter) {
            ['key' => $key, 'type' => $type, 'children' => $children] = $n;
            switch ($type) {
                case 'added':
                    $acc .= "Property {'$key'} was added with value: {'$n[newValue]'}";
            }
            return $acc;
        }, '');
    };
}