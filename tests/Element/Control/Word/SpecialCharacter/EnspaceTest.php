<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class EnspaceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('enspace', (new Enspace())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&ensp;', (new Enspace())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&ensp;'),
            (new Enspace())->format('text')
        );
    }
}
