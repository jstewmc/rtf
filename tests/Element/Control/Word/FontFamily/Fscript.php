<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FscriptTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fscript', (new Fscript())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals('Cursive', (new Fscript())->getFonts());
    }
}
