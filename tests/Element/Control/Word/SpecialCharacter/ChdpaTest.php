<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class ChdpaTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('chdpa', (new Chdpa())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('l, j F Y'),
            (new Chdpa())->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('l, j F Y'),
            (new Chdpa())->format('text')
        );
    }
}
