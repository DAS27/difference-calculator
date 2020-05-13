<?php

namespace Differ;

use function Renderer\render;
use function Ast\buildDiff;

//принимает путь к файлу
function genDiff($pathToFile1, $pathToFile2)
{
    //парсит данные по пути к файлу
    $dataFromPath1 = file_get_contents($pathToFile1);
    $dataFromPath2 = file_get_contents($pathToFile2);

    //возвращает сгенерированный диф т.е. результат
    $dataToArray1 = json_decode($dataFromPath1, true);
    $dataToArray2 = json_decode($dataFromPath2, true);

    $result = buildDiff($dataToArray1, $dataToArray2);
    return render($result);
}
