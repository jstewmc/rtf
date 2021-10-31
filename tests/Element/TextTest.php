<?php

namespace Jstewmc\Rtf\Element;

class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTextReturnsString(): void
    {
        $this->assertEquals('foo', (new Text('foo')));
    }

    public function testSetTextReturnsSelf(): void
    {
        $text = new Text('foo');

        $this->assertSame($text, $text->setText('bar'));
    }

    public function testToStringReturnsString(): void
    {
        $this->assertEquals('foo', (string)(new Text('foo')));
    }

    public function testToHtmlReturnsString(): void
    {
        $this->assertEquals('foo &amp; bar', (new Text('foo & bar'))->toHtml());
    }

    public function testToRtfReturnsString(): void
    {
        $this->assertEquals('foo \\\\ bar', (new Text('foo \ bar'))->toRtf());
    }

    public function testToTextReturnsString(): void
    {
        $this->assertEquals('foo & bar', (new Text('foo & bar'))->toText());
    }
}
