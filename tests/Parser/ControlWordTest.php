<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\{
    Element\Control\Word as Element,
    Token\Control\Word as Token
};

class ControlWordTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsElementWhenWordIsSpecific(): void
    {
        $this->assertInstanceOf(
            Element\B::class,
            (new ControlWord())(new Token('b'))
        );
    }

    public function testInvokeReturnsElementWhenWordIsGeneric(): void
    {
        $this->assertEquals(
            new Element\Word('foo'),
            (new ControlWord())(new Token('foo'))
        );
    }
}
