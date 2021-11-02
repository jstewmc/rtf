<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class AsteriskTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('*', (new Asterisk())->getSymbol());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('', (new Asterisk())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals('', (new Asterisk())->format('text'));
    }
}
