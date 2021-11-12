<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class RquoteTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('rquote', (new Rquote())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&rsquo;', (new Rquote())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&rsquo;'),
            (new Rquote())->format('text')
        );
    }
}
