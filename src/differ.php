<?php

namespace Differ;

use function Differ\Ast\buildDiff;
use function Differ\Renderer\render;
use function Differ\Formatter\renderPlainDiff;
use function Differ\Formatter\renderJsonDiff;
use function Differ\Parsers\parse;

function genDiff($path1, $path2, $format = 'pretty')
{
    $content1 = file_get_contents($path1);
    $content2 = file_get_contents($path2);

    $dataType1 = pathinfo($path1)['extension'];
    $dataType2 = pathinfo($path2)['extension'];

    $data1 = parse($content1, $dataType1);
    $data2 = parse($content2, $dataType2);

    $diff = buildDiff($data1, $data2);

    switch ($format) {
        case 'pretty':
            return render($diff);
        case 'plain':
            return renderPlainDiff($diff);
        case 'json':
            return renderJsonDiff($diff);
        default:
            throw new \Error('Error format is wrong!');
    }
}
