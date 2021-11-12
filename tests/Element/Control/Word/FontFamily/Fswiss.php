<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FswissTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fswiss', (new Fswiss())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals('Arial', (new Fswiss())->getFonts());
    }
}
