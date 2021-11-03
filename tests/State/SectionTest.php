<?php

namespace Jstewmc\Rtf\State;

class SectionTest extends \PHPUnit\Framework\TestCase
{
    public function testGetIndexReturnsInt(): void
    {
        $this->assertEquals(0, (new Section())->getIndex());
    }

    public function testSetIndexReturnsSelf(): void
    {
        $state = new Section();

        $this->assertSame($state, $state->setIndex(1));
    }
}
