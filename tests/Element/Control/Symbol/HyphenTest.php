<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class HyphenTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('-', (new Hyphen())->getSymbol());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('-', (new Hyphen())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals('-', (new Hyphen())->format('text'));
    }
}
