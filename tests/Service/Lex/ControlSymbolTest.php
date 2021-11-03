<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Text,
    Token\Control\Symbol
};

class ControlSymbolTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeThrowsInvalidArgumentExceptionWhenCurrentCharacterIsNotBackslash(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ControlSymbol())($this->stream('foo'));
    }

    public function testInvokeThrowsInvalidArgumentExceptionWhenNextCharacterIsAlphabetic(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ControlSymbol())($this->stream('\\b'));
    }

    public function testInvokeReturnsSymbolWhenAtStreamEnd(): void
    {
        $this->assertEquals(
            (new Symbol('_'))->setIsSpaceDelimited(false),
            (new ControlSymbol())($this->stream('\\_'))
        );
    }

    public function testCreateFromStreamReturnsSymbolWhenAtStreamMiddle(): void
    {
        $this->assertEquals(
            (new Symbol('_'))->setIsSpaceDelimited(false),
            (new ControlSymbol())($this->stream('\\_a'))
        );
    }

    public function testCreateFromStreamReturnsSymbolWhenIsSpaceDelimited(): void
    {
        $this->assertEquals(
            (new Symbol('_'))->setIsSpaceDelimited(true),
            (new ControlSymbol())($this->stream('\\_ '))
        );
    }

    public function testCreateFromStreamReturnsSymbolWhenSymbolIsApostrophe(): void
    {
        $this->assertEquals(
            (new Symbol('\''))->setParameter('ab')->setIsSpaceDelimited(false),
            (new ControlSymbol())($this->stream("\\'ab"))
        );
    }

    private function stream(string $content): Text
    {
        return new Text($content);
    }
}
