<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class ChtimeTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('chtime', (new Chtime())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('H:i:s'),
            (new Chtime())->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('H:i:s'),
            (new Chtime())->format('text')
        );
    }
}
