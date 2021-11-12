<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FmodernTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fmodern', (new Fmodern())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals('Courier New, Pica', (new Fmodern())->getFonts());
    }
}
