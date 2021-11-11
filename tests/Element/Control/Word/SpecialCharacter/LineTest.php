<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class LineTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('line', (new Line())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('<br>', (new Line())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals("\n", (new Line())->format('text'));
    }
}
