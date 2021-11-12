<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class EndashTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('endash', (new Endash())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&endash;', (new Endash())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&endash;'),
            (new Endash())->format('text')
        );
    }
}
