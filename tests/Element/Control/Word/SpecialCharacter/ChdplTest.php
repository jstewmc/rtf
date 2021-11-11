<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class ChdplTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('chdpa', (new Chdpa())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('D, j M Y'),
            (new Chdpl())->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('D, j M Y'),
            (new Chdpl())->format('text')
        );
    }
}
