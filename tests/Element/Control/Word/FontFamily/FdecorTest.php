<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FdecorTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fdecor', (new Fdecor())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals(
            'Old English, ITC Zapf Chancery',
            (new Fdecor())->getFonts()
        );
    }
}
