<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;

class DifferTest extends TestCase
{
    protected $path1 = __DIR__ . '/fixtures/before.json';
    protected $path2 = __DIR__ . '/fixtures/after.json';
    protected $path3 = __DIR__ . '/fixtures/before.yml';
    protected $path4 = __DIR__ . '/fixtures/after.yml';

    public function testGenDiff()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path1, $this->path2);
        $this->assertEquals($expected, $actual);
    }

    public function testGenDiff2()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path3, $this->path4);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderPlainDiff()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.plain');
        $actual = genDiff($this->path1, $this->path2, 'plain');
        $this->assertEquals($expected, $actual);
    }

    public function testRenderPlainDiff2()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path3, $this->path4);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderJsonDiff()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.json');
        $actual = genDiff($this->path1, $this->path2, 'json');
        $this->assertEquals($expected, $actual);
    }

    public function testRenderJsonDiff2()
    {
        $expected = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
        $actual = genDiff($this->path3, $this->path4);
        $this->assertEquals($expected, $actual);
    }
}
