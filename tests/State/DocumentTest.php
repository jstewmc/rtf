<?php

namespace Jstewmc\Rtf\State;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function testFormatReturnsString(): void
    {
        $this->assertEquals('', (new Document())->format('foo'));
    }
}
