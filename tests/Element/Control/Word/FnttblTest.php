<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class FnttblTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('fonttbl', (new Fonttbl())->getWord());
    }
}
