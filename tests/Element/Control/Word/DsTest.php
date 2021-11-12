<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class DsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ds', (new Ds(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Ds(0))->getNumber());
    }
}
