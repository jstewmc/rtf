<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class FTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('f', (new F(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new F(0))->getNumber());
    }
}
