<?php

namespace Jstewmc\Rtf\Element\HeaderTable;

class StylesheetTest extends \PHPUnit\Framework\TestCase
{
    public function testToHtmlReturnsString(): void
    {
        $this->assertEquals('', (new Stylesheet())->toHtml());
    }

    public function testToTextReturnsString(): void
    {
        $this->assertEquals('', (new Stylesheet())->toText());
    }
}
