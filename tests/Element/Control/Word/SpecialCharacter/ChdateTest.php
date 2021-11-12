<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class ChdateTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('chdate', (new Chdate())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('m.d.Y'),
            (new Chdate())->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('m.d.Y'),
            (new Chdate())->format('html')
        );
    }
}
