<?php

namespace Differ\Formatters;

use function Differ\Renderer\render;

function getFormatter($format)
{
    return function ($diff) use ($format) {
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
    };
}
