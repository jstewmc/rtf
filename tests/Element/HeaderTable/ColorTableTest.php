<?php

namespace Jstewmc\Rtf\Element\HeaderTable;

class ColorTableTest extends \PHPUnit\Framework\TestCase
{
    public function testToHtmlReturnsString(): void
    {
        $this->assertEquals('', (new ColorTable())->toHtml());
    }

    public function testToTextReturnsString(): void
    {
        $this->assertEquals('', (new ColorTable())->toText());
    }
}
