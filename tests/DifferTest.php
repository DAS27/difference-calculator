<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;

class DifferTest extends TestCase
{
    protected $data;

    protected function setUp(): void
    {
        $this->data = "host: hexlet.io\n+ timeout: 20\n- timeout: 50\n- proxy: 123.234.53.22\n+ verbose: true\n";
    }

    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . '/fixtures/before.json';
        $pathToFile2 = __DIR__ . '/fixtures/after.json';

        $actual = genDiff($pathToFile1, $pathToFile2);
        $this->assertEquals($this->data, $actual);
    }
}