<?php

namespace Renderer;

use function Funct\Collection\flatten;

function doRender($tree)
{
    /*
    $level = 0;
    $iter = array_map(function ($node) use (&$iter, $result) {
        ['key' => $key, 'type' => $type] = $node;
        switch ($type) {
            case 'nested':
                $result = $iter($node['children']);
        }
        return $result;
    }, $tree);

    return $iter;
    */
    $level = 0;
    $iter = array_map(function ($node) use (&$iter, $level) {
        ['type' => $type] = $node;
        switch ($type) {
            case 'nested':
                print_r($iter($node['children']));
        }
    }, $tree);
    return $iter($tree);
}
/*
 function iter($tree) {
    if ()
    return stringify($tree);
 }
*/