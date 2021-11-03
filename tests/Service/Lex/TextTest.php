<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{Stream, Token};

class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsTextWhenTextHasControlWord(): void
    {
        $this->assertEquals(
            new Token\Text('foo '),
            (new Text())($this->stream('foo \\bar'))
        );
    }

    public function testInvokeReturnsTextWhenTextHasControlSymbol(): void
    {
        $this->assertEquals(
            new Token\Text('foo '),
            (new Text())($this->stream('foo \\+'))
        );
    }

    public function testInvokeReturnsTextWhenTextHasGroupOpen(): void
    {
        $this->assertEquals(
            new Token\Text('foo '),
            (new Text())($this->stream('foo {'))
        );
    }

    public function testInvokeReturnsTextWhenTextHasGroupClose(): void
    {
        $this->assertEquals(
            new Token\Text('foo '),
            (new Text())($this->stream('foo }'))
        );
    }

    public function testInvokeReturnsTextWhenTextHasUnescapedLineFeed(): void
    {
        $this->assertEquals(
            new Token\Text('foobar'),
            (new Text())($this->stream("foo\nbar"))
        );
    }

    public function testInvokeReturnsTextWhenTextHasLineFeedEscaped(): void
    {
        $this->assertEquals(
            new Token\Text('foo'),
            (new Text())($this->stream("foo\\\nbar"))
        );
    }

    public function testInvokeReturnsTextWhenTextHasCarriageReturnUnescaped(): void
    {
        $this->assertEquals(
            new Token\Text('foobar'),
            (new Text())($this->stream("foo\rbar"))
        );
    }

    public function testInvokeReturnsTextWhenTextHasCarriageReturnEscaped(): void
    {
        $this->assertEquals(
            new Token\Text('foo'),
            (new Text())($this->stream("foo\\\rbar"))
        );
    }

    public function testInvokeReturnsTextWhenTextEvaluatesToEmpty(): void
    {
        $this->assertEquals(
            new Token\Text('0'),
            (new Text())($this->stream('0'))
        );
    }

    private function stream(string $content): Stream\Text
    {
        return new Stream\Text($content);
    }
}
