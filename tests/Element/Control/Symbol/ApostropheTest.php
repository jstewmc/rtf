<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class ApostropheTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSymbolReturnsApostrophe(): void
    {
        $this->assertEquals('\'', (new Apostrophe('1'))->getSymbol());
    }

    public function testFormatReturnsStringWhenHtml(): void
    {
        $this->assertEquals('&#x22;', (new Apostrophe('22'))->format('html'));
    }

    public function testFormatReturnsStringWhenText(): void
    {
        $this->assertEquals(
            html_entity_decode('&#x22;'),
            (new Apostrophe('22'))->format('text')
        );
    }
}
