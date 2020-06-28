<?php

namespace Differ\Formatters;

use function Differ\Renderer\render;

function getFormatter($format)
{
    $getFormatter = function () {
        return 
    };

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

    return $getFormatter();
}