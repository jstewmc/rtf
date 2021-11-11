<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

class MacTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('mac', (new Mac())->getWord());
    }

    public function testGetEncodingReturnsString(): void
    {
        $this->assertEquals('macintosh', (new Mac())->getEncoding());
    }
}
