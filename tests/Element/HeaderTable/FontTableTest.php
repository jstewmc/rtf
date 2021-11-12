<?php

namespace Jstewmc\Rtf\Element\HeaderTable;

class FontTableTest extends \PHPUnit\Framework\TestCase
{
    public function testToHtmlReturnsString(): void
    {
        $this->assertEquals('', (new FontTable())->toHtml());
    }

    public function testToTextReturnsString(): void
    {
        $this->assertEquals('', (new FontTable())->toText());
    }
}
