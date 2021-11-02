<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class UTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('u', (new U(60))->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        // "&#60" is the less-than character
        $this->assertEquals('&#60;', (new U(60))->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&#60;'),
            (new U(60))->format('text')
        );
    }
}
