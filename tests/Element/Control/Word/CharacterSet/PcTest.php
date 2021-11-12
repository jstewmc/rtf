<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

class PcTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('pc', (new Pc())->getWord());
    }

    public function testGetEncodingReturnsString(): void
    {
        $this->assertEquals('IBM437', (new Pc())->getEncoding());
    }
}
