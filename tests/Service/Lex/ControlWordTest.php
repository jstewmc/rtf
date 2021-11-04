<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Text,
    Token\Control\Word
};

class ControlWordTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeThrowsInvalidArgumentExceptionWhenCurrentCharacterIsNotBackslash(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ControlWord())($this->stream('foo'));
    }

    public function testInvokeThrowsInvalidArgumentExceptionWhenNextCharacterIsNotAlphabetic(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ControlWord())($this->stream('\\1'));
    }

    public function testInvokeReturnsTokenWhenParameterDoesNotExistAndDelimiterIsSpace(): void
    {
        $this->assertEquals(
            new Word('foo'),
            (new ControlWord())($this->stream('\\foo bar'))
        );
    }

    public function testInvokeReturnsTokenWhenParameterDoesNotExistAndDelimiterIsCharacter(): void
    {
        $this->assertEquals(
            (new Word('foo'))->setIsSpaceDelimited(false),
            (new ControlWord())($this->stream('\\foo+bar'))
        );
    }

    public function testInvokeReturnsTokenWhenParameterIsPositive(): void
    {
        $this->assertEquals(
            (new Word('foo'))->setParameter(123),
            (new ControlWord())($this->stream('\\foo123 bar'))
        );
    }

    public function testInvokeReturnsTokenWhenarameterIsNegative(): void
    {
        $this->assertEquals(
            (new Word('foo'))->setParameter(-123),
            (new ControlWord())($this->stream('\\foo-123 bar'))
        );
    }

    public function testInvokeReturnsTokenWhenParameterExistsAndDelimiterIsSpace(): void
    {
        $this->assertEquals(
            (new Word('foo'))->setParameter(1),
            (new ControlWord())($this->stream('\\foo1 bar'))
        );
    }

    public function testInvokeReturnsTokenWhenParameterExistsAndDelimiterIsCharacter(): void
    {
        $this->assertEquals(
            (new Word('foo'))->setParameter(1)->setIsSpaceDelimited(false),
            (new ControlWord())($this->stream('\\foo1+bar'))
        );
    }

    private function stream(string $content): Text
    {
        return new Text($content);
    }
}
