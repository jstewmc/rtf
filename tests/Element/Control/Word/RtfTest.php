<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class RtfTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('rtf', (new Rtf(1))->getWord());
    }
}
