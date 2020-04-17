<?php

namespace Renderer;

use function Funct\Collection\flatten;

function doRender($tree)
{
    $level = 0;
    return array_map(function ($node) {
        return iter($node);
//        print_r(iter($node));
    }, $tree);
}

function iter($node)
{
    ['type' => $type] = $node;
    $result = '';
    switch ($type) {
        case 'nested':
             if ($node['children']) {
                 return array_map(function ($n) {
                     return iter($n);
                 }, $node['children']);
             }
        case 'added':
            return stringify($node);
    }
    return $result;
}

function stringify($node)
{
    $level = 0;
    return array_map(function ($n) use ($level) {
//        print_r($n);
        if (($n)) {
            print_r(json_encode($n));
        }
    }, $node);
}