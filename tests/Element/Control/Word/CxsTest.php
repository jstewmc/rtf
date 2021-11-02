<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class CxsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxs', (new Cxs())->getWord());
    }
}
