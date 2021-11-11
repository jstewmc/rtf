<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

class AnsiTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ansi', (new Ansi())->getWord());
    }
}
