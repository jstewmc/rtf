<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CxstitTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxstit', (new Cxstit())->getWord());
    }
}
