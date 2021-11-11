<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

class FromanTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('froman', (new Froman())->getWord());
    }

    public function testGetFontsReturnsString(): void
    {
        $this->assertEquals(
            'Times New Roman, Palatino',
            (new Froman())->getFonts()
        );
    }
}
