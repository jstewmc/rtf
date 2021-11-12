<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class DeffTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('deff', (new Deff(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Deff(0))->getNumber());
    }
}
