<?php

namespace Docopt;

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
    --format <fmt>                Report format: plain [default: pretty]
    
DOC;

    $params = array(
        'argv' => array_slice($_SERVER['argv'], 1),
        'help' => true,
        'version' => 'Docopt 2.0',
    );
    $args = Docopt::handle($doc, $params);
    $path1 = $args['<firstFile>'];
    $path2 = $args['<secondFile>'];
    $format = $args['--format'];
    echo genDiff($path1, $path2, $format);
}
