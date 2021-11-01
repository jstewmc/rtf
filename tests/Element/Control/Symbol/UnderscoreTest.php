<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class UnderscoreTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('_', (new Underscore())->getSymbol());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('-', (new Underscore())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals('-', (new Underscore())->format('text'));
    }
}
