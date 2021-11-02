<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CxaTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxa', (new Cxa())->getWord());
    }
}
