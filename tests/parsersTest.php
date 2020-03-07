<?php

namespace Parsers\Test;

use PHPUnit\Framework\TestCase;
use function Parsers\genDiff;

class ParsersTest extends TestCase
{
    protected $data;

    protected function setUp() : void
    {
        $this->data = "host: hexlet.io\n+ timeout: 20\n- timeout: 50\n- proxy: 123.234.53.22\n+ verbose: true\n";
    }

    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . '/fixtures/before.yml';
        $pathToFile2 = __DIR__ . '/fixtures/after.yml';

        $actual = genDiff($pathToFile1, $pathToFile2);
        $this->assertEquals($this->data, $actual);
    }
}
