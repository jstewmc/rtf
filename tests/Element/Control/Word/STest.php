<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class STest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('s', (new S(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new S(0))->getNumber());
    }
}
