<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;
use function Formatter\renderPlainDiff;

class DifferTest extends TestCase
{
    protected $path1 = __DIR__ . '/fixtures/before.json';
    protected $path2 = __DIR__ . '/fixtures/after.json';

    //TODO: переделать тесты! Выводить результат в зависимости от формата.
    public function testGenDiff()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path1, $this->path2);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderPlainDiff()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.plain');
        $actual = genDiff($this->path1, $this->path2, 'plain');
        $this->assertEquals($expected, $actual);
    }
}
