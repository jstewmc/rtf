<?php

namespace Jstewmc\Rtf\Token\Control;

class SymbolTest extends \PHPUnit\Framework\TestCase
{
    public function testSetIsSpaceDelimitedReturnsSelf(): void
    {
        $symbol = new Symbol('+');

        $this->assertSame($symbol, $symbol->setIsSpaceDelimited(true));
    }

    public function testGetIsSpaceDelimitedReturnsBoolean(): void
    {
        $this->assertTrue((new Symbol('+'))->getIsSpaceDelimited());
    }

    public function testGetParameterReturnsString(): void
    {
        $this->assertEquals('', (new Symbol('+'))->getParameter());
    }

    public function testSetParameterReturnsSelf(): void
    {
        $symbol = new Symbol('+');

        $this->assertSame($symbol, $symbol->setParameter('b'));
    }

    public function testGetSymbolReturnsString(): void
    {
        $this->assertEquals('+', (new Symbol('+'))->getSymbol());
    }

    public function testToStringReturnsStringWhenParameterDoesNotExist(): void
    {
        $this->assertEquals('\\+ ', (string)(new Symbol('+')));
    }

    public function testToStringReturnsStringWhenParameterExists(): void
    {
        $this->assertEquals("\\'99 ", (new Symbol('\''))->setParameter('99'));
    }

    public function testToStringReturnsStringWhenNotSpaceDelimited(): void
    {
        $this->assertEquals('\\+', (new Symbol('+'))->setIsSpaceDelimited(false));
    }

    public function testHasParameterReturnsFalseWhenParameterDoesNotExist(): void
    {
        $this->assertFalse((new Symbol('+'))->hasParameter());
    }

    public function testHasParameterReturnsTrueWhenParameterExists(): void
    {
        $this->assertTrue((new Symbol('+'))->setParameter(1)->hasParameter());
    }
}
