<?php

$doc = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)

Options:
  -h --help                     Show this screen
  -v --version                  Show version

DOC;

require('../vendor/docopt/docopt/src/docopt.php');
$args = Docopt::handle($doc, array('version' => 'Generate diff 2.0'));
foreach ($args as $k => $v)
    echo $k . ': ' . json_encode($v) . PHP_EOL;
