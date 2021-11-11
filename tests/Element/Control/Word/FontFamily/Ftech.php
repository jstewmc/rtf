<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FtechTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ftech', (new Ftech())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals('Symbol', (new Ftech())->getFonts());
    }
}
