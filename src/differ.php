<?php

namespace Differ;

use function Ast\buildDiff;
use function Renderer\render;
use function Formatter\renderPlainDiff;
use function Formatter\renderJsonDiff;
use function Parsers\parse;

function genDiff($path1, $path2, $format = 'pretty')
{
    $extension1 = pathinfo($path1);
    $extension2 = pathinfo($path2);

    $data1 = parse($path1, $extension1['extension']);
    $data2 = parse($path2, $extension2['extension']);

    $diff = buildDiff($data1, $data2);

    if ($format == 'plain') {
        return renderPlainDiff($diff);
    } elseif ($format == 'json') {
        return renderJsonDiff($diff);
    }

    return render($diff);
}
