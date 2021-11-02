<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CxfingTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxfing', (new Cxfing())->getWord());
    }
}
