<?php

namespace Differ;

use function Differ\AstBuilder\buildDiff;
use function Differ\Parsers\parse;
use function Differ\Formatters\getFormatter;

function genDiff($path1, $path2, $format = 'pretty')
{
    $content1 = file_get_contents($path1);
    $content2 = file_get_contents($path2);

    $dataType1 = pathinfo($path1)['extension'];
    $dataType2 = pathinfo($path2)['extension'];

    $data1 = parse($content1, $dataType1);
    $data2 = parse($content2, $dataType2);

    $diff = buildDiff($data1, $data2);

    $getFormatter = getFormatter($format);

    return $getFormatter($diff);
}
