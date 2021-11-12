<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class TabTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('tab', (new Tab())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&emsp;', (new Tab())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals("\t", (new Tab())->format('text'));
    }
}
