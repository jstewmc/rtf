<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FnilTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fnil', (new Fnil())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals('', (new Fnil())->getFonts());
    }
}
