<?php

namespace Differ;

use function Renderer\render;
use function Ast\buildDiff;
use function Formatter\renderPlainDiff;

//принимает путь к файлу
function genDiff($path1, $path2, $format = 'pretty')
{
    //парсит данные по пути к файлу
    $data1 = file_get_contents($path1);
    $data2 = file_get_contents($path2);
    //преобразует данные в ассоц массив
    $array1 = json_decode($data1, true);
    $array2 = json_decode($data2, true);
    //строит промежуточное представление
    $diff = buildDiff($array1, $array2);
    //выводит данные в зависимости от формата
    if ($format === 'plain') {
        return renderPlainDiff($diff);
    }

    return render($diff);
}
