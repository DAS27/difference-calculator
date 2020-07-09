<?php

namespace Differ\Formatters\Json;

function renderJsonDiff($tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}
