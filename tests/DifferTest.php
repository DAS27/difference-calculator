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

        $data = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path1, $this->path2);
        $this->assertEquals($data, $actual);
    }

    public function testRenderPlainDiff()
    {
        $data = "
            Property 'common.setting2' was removed
            Property 'common.setting6' was removed
            Property 'common.setting4' was added with value: 'blah blah'
            Property 'common.setting5' was added with value: 'complex value'
            Property 'group1.baz' was changed. From 'bas' to 'bars'
            Property 'group2' was removed
            Property 'group3' was added with value: 'complex value'";

        $diff = genDiff($this->path1, $this->path2);
        $expected = renderPlainDiff($diff);
        $this->assertEquals($data, $expected);
    }
}
