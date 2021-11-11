<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class FcharsetTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fcharset', (new Fcharset(0))->getWord());
    }
}
