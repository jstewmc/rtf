<?php

namespace Jstewmc\Rtf\State;

class ParagraphTest extends \PHPUnit\Framework\TestCase
{
    public function testGetIndexReturnsInt(): void
    {
        $this->assertEquals(0, (new Paragraph())->getIndex());
    }

    public function testSetIndexReturnsSelf(): void
    {
        $state = new Paragraph();

        $this->assertSame($state, $state->setIndex(1));
    }
}
