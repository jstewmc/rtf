<?php

namespace Jstewmc\Rtf\Element\Control\Word\Color;

class RedTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('red', (new Red(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Red(0))->getIndex());
    }
}
