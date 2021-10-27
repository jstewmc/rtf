<?php

namespace Jstewmc\Rtf\Token;

class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTextReturnsString(): void
    {
        $this->assertEquals('foo', (new Text('foo'))->getText());
    }

    public function testToStringReturnsString(): void
    {
        $this->assertEquals('foo', (string)(new Text('foo')));
    }
}
