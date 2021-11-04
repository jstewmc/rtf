<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{
    Token\Control\Symbol as Token,
    Element\Control\Symbol as Element
};

class ControlSymbolTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsElementWhenSymbolIsSpecific(): void
    {
        $this->assertInstanceOf(
            Element\Asterisk::class,
            (new ControlSymbol())(new Token('*'))
        );
    }

    public function testInvokeReturnsElementWhenSymbolIsGenerci(): void
    {
        $this->assertEquals(
            new Element\Symbol('#'),
            (new ControlSymbol())(new Token('#'))
        );
    }
}