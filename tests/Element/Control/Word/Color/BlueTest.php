<?php

namespace Jstewmc\Rtf\Element\Control\Word\Color;

class BlueTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('blue', (new Blue(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Blue(0))->getIndex());
    }
}
