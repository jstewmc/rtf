<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class RdblquoteTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('rdblquote', (new Rdblquote())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&rdquo;', (new Rdblquote())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&rdquo;'),
            (new Rdblquote())->format('text')
        );
    }
}
