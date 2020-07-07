<?php

namespace Differ\Formatters;

function renderJsonDiff($tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}
