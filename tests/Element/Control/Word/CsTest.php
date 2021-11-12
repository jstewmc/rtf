<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cs', (new Cs(0))->getWord());
    }

    public function testGetNumberReturnsInt(): void
    {
        $this->assertEquals(0, (new Cs(0))->getNumber());
    }
}
