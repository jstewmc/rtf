<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class TildeTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('~', (new Tilde())->getSymbol());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&nbsp;', (new Tilde())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&nbsp;'),
            (new Tilde())->format('text')
        );
    }
}
