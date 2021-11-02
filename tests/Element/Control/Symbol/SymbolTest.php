<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class SymbolTest extends \PHPUnit\Framework\TestCase
{
    public function testSetParameterReturnsSelf(): void
    {
        $symbol = new Symbol('foo');

        $this->assertSame($symbol, $symbol->setParameter('bar'));
    }

    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('+', (new Symbol('+'))->getSymbol());
    }


    public function testConstructReturnsSymbolWhenParameterIsNotNull(): void
    {
        $this->assertEquals(1, (new Symbol('foo', 1))->getParameter());
    }

    public function testToStringReturnsStringWhenParameterDoesNotExist(): void
    {
        $this->assertEquals('\\* ', (string)(new Symbol('*')));
    }

    public function testToStringReturnsStringWhenParameterDoesExist(): void
    {
        $this->assertEquals('\\\'foo ', (string)(new Symbol('\'', 'foo')));
    }

    public function testToStringReturnsStringWhenNotSpaceDelimited(): void
    {
        $this->assertEquals('\\+', (string)(new Symbol('+'))->setIsSpaceDelimited(false));
    }
}
