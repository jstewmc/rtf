<?php

namespace Jstewmc\Rtf\Element\Control\Word\Color;

class GreenTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('green', (new Green(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Green(0))->getIndex());
    }
}
