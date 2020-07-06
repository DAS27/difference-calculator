<?php

namespace Differ\Formatters;

use Error;

use function Differ\Formatters\renderPlainDiff\renderPlainDiff;
use function Differ\Formatters\RenderPrettyDiff\renderPrettyDiff;

function getFormatter($format)
{
    return function ($diff) use ($format) {
        switch ($format) {
            case 'pretty':
                return renderPrettyDiff($diff);
            case 'plain':
                return renderPlainDiff($diff);
            case 'json':
                return json_encode($diff, JSON_PRETTY_PRINT);
            default:
                throw new Error("Unknown format: {$format}");
        }
    };
}
