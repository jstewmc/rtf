<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class ApostropheTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsApostrophe(): void
    {
        $this->assertEquals('\'', (new Apostrophe('1'))->getSymbol());
    }

    public function testGetEncodingReturnsString(): void
    {
        $this->assertEquals('windows-1252', (new Apostrophe('1'))->getEncoding());
    }

    public function testSetEncodingReturnsSelf(): void
    {
        $symbol = new Apostrophe('1');

        $this->assertSame($symbol, $symbol->setEncoding('ISO-8859-6'));
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            $this->characterAnsi(),
            (new Apostrophe($this->parameter()))->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            $this->characterAnsi(),
            (new Apostrophe($this->parameter()))->format('text')
        );
    }

    public function testFormatReturnsStringWhenEncodingIsNotDefault(): void
    {
        $symbol = new Apostrophe($this->parameter());
        $symbol->setEncoding('macintosh');

        $this->assertEquals(
            $this->characterMacintosh(),
            $symbol->format('text')
        );
    }

    private function parameter(): string
    {
        return '80';  // 128 in hex
    }

    private function characterAnsi(): string
    {
        // the 128th character in the "windows-1252" (aka, "ansi") character set
        return '€';
    }

    private function characterMacintosh(): string
    {
        // the 128th character in the "macintosh" character set
        return 'Ä';
    }
}
