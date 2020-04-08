<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;

class DifferTest extends TestCase
{
    protected $data;

    protected function setUp(): void
    {
        $this->data = file_get_contents(__DIR__ . '/fixtures/diff.pretty');
    }

    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . '/fixtures/before.json';
        $pathToFile2 = __DIR__ . '/fixtures/after.json';

        $actual = genDiff($pathToFile1, $pathToFile2);
        $this->assertEquals($this->data, $actual);
    }
}