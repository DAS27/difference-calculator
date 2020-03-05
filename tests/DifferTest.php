<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;

class DifferTest extends TestCase
{
    protected $data;
    protected $pathToFile1;
    protected $pathToFile2;

    protected function setUp(): void
    {
        $this->data = "host: hexlet.io\n+ timeout: 20\n- timeout: 50\n- proxy: 123.234.53.22\n+ verbose: true\n";
        $this->pathToFile1 = __DIR__ . '/fixtures/before.json';
        $this->pathToFile2 = __DIR__ . '/fixtures/after.json';
    }

    public function testGenDiff()
    {
        $actual = genDiff($this->pathToFile1, $this->pathToFile2);
        $this->assertEquals($this->data, $actual);
    }
}