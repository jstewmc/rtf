<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class EmspaceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('emspace', (new Emspace())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&emsp;', (new Emspace())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&emsp;'),
            (new Emspace())->format('text')
        );
    }
}
