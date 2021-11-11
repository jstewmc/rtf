<?php

namespace Jstewmc\Rtf\Service\Parse;

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

    public function testInvokeReturnsElementWhenWordHasParameter(): void
    {
        $this->assertEquals(
            new Element\Rtf(1),
            (new ControlWord())((new Token('rtf'))->setParameter(1))
        );
    }

    public function testInvokeReturnsElementWhenWordIsGeneric(): void
    {
        $this->assertEquals(
            new Element\Word('foo'),
            (new ControlWord())(new Token('foo'))
        );
    }

    public function testInvokeReturnsElementWhenWordIsTyped(): void
    {
        $this->assertEquals(
            new Element\FontFamily\Fnil(),
            (new ControlWord())(new Token('fnil'))
        );
    }
}
