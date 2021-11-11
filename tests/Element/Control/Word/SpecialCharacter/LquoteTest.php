<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class LquoteTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('lquote', (new Lquote())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&lsquo;', (new Lquote())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&lsquo;'),
            (new Lquote())->format('text')
        );
    }
}
