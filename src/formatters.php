<?php

namespace Differ\Formatters;

use function Differ\Formatters\Json\renderJsonDiff;
use function Differ\Formatters\Plain\renderPlainDiff;
use function Differ\Formatters\Pretty\renderPrettyDiff;

function getFormatter($format)
{
    return function ($diff) use ($format) {
        switch ($format) {
            case 'pretty':
                return renderPrettyDiff($diff);
            case 'plain':
                return renderPlainDiff($diff);
            case 'json':
                return renderJsonDiff($diff);
            default:
                throw new \Exception("Unknown format: {$format}");
        }
    };
}
