<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class ColortblTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('colortbl', (new Colortbl())->getWord());
    }
}
