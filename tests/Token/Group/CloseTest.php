<?php

namespace Jstewmc\Rtf\Token\Group;

class CloseTest extends \PHPUnit\Framework\TestCase
{
    public function testToStringReturnsString(): void
    {
        $this->assertEquals('}', (string)(new Close()));
    }
}
