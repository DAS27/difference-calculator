<?php

namespace GenDiff;

use Docopt;

use function Differ\genDiff;

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
    $firstFile = $args['<firstFile>'];
    $secondFile = $args['<secondFile>'];
    echo genDiff($firstFile, $secondFile);
}
