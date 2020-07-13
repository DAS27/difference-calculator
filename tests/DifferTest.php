<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixtureFullPath($fixtureName)
    {
        $pathToFile = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode(DIRECTORY_SEPARATOR, $pathToFile));
    }

    public function testRenderPrettyDiff()
    {
        $expected = file_get_contents($this->getFixtureFullPath('diff.pretty'));
        $actual = genDiff($this->getFixtureFullPath('before.json'), $this->getFixtureFullPath('after.yml'));
        $this->assertEquals($expected, $actual);
    }

    public function testRenderPlainDiff()
    {
        $expected = file_get_contents($this->getFixtureFullPath('diff.plain'));
        $actual = genDiff($this->getFixtureFullPath('before.yml'), $this->getFixtureFullPath('after.json'), 'plain');
        $this->assertEquals($expected, $actual);
    }

    public function testRenderJsonDiff()
    {
        $expected = file_get_contents($this->getFixtureFullPath('diff.json'));
        $actual = genDiff($this->getFixtureFullPath('before.json'), $this->getFixtureFullPath('after.json'), 'json');
        $this->assertEquals($expected, $actual);
    }
}
