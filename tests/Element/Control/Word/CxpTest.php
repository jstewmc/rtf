<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CxpTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxp', (new Cxp())->getWord());
    }
}
