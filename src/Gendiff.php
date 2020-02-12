<?php

namespace GenDiff;

use Docopt;

function run()
{
    $doc = <<<DOC
    Generate diff

    Usage:
    gendiff (-h|--help)
    gendiff (-v|--version)
    gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
    -h --help                     Show this screen
    -v --version                  Show version
    --format <fmt>                Report format [default: pretty]
    
DOC;

    $params = array(
        'argv' => array_slice($_SERVER['argv'], 1),
        'help' => true,
        'version' => 'Docopt 2.0',
    );
    $args = Docopt::handle($doc, $params);
    foreach ($args as $k => $v) {
        echo $k . ': ' . json_encode($v) . PHP_EOL;
    }
}
