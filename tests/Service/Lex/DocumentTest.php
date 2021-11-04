<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{Stream, Token};


class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsArrayWhenContentIsEmpty(): void
    {
        $this->assertEquals([], (new Document())($this->stream('')));
    }

    public function testInvokeReturnsArrayWhenContentIsGroupOpen(): void
    {
        $this->assertEquals(
            [new Token\Group\Open()],
            (new Document())($this->stream('{'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsGroupClose(): void
    {
        $this->assertEquals(
            [new Token\Group\Close()],
            (new Document())($this->stream('}'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsControlWordWithSpace(): void
    {
        $this->assertEquals(
            [(new Token\Control\Word('foo'))->setIsSpaceDelimited(true)],
            (new Document())($this->stream('\foo '))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsControlWordWithoutSpace(): void
    {
        $this->assertEquals(
            [(new Token\Control\Word('foo'))->setIsSpaceDelimited(false)],
            (new Document())($this->stream('\foo'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsControlSymbolWithSpace(): void
    {
        $this->assertEquals(
            [(new Token\Control\Symbol('+'))->setIsSpaceDelimited(true)],
            (new Document())($this->stream('\+ '))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsControlSymbolWithoutSpace(): void
    {
        $this->assertEquals(
            [(new Token\Control\Symbol('+'))->setIsSpaceDelimited(false)],
            (new Document())($this->stream('\+'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsText(): void
    {
        $this->assertEquals(
            [new Token\Text('foo')],
            (new Document())($this->stream('foo'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsFalsey(): void
    {
        $this->assertEquals(
            [new Token\Text('0')],
            (new Document())($this->stream('0'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsLiteral(): void
    {
        $this->assertEquals(
            // Remember PHP uses the "\" as its own escape character.
            [new Token\Text('\\')],
            (new Document())($this->stream('\\\\'))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsLineFeedEscaped(): void
    {
        $this->assertEquals(
            [new Token\Control\Word('par')],
            (new Document())($this->stream("\\\n"))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsLineFeedUnescaped(): void
    {
        $this->assertEquals(
            [new Token\Text('foo')],
            (new Document())($this->stream("f\noo"))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsCarriageReturnEscaped(): void
    {
        $this->assertEquals(
            [new Token\Control\Word('par')],
            (new Document())($this->stream("\\\r"))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsCarriageReturnUnescaped(): void
    {
        $this->assertEquals(
            [new Token\Text('foo')],
            (new Document())($this->stream("f\roo"))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsTabCharacter(): void
    {
        $this->assertEquals(
            [new Token\Control\Word('tab')],
            (new Document())($this->stream("\t"))
        );
    }

    public function testInvokeReturnsArrayWhenContentIsGroup(): void
    {
        $expected = [
            new Token\Group\Open(),
            (new Token\Control\Word('b'))->setIsSpaceDelimited(true),
            new Token\Text('foo '),
            (new Token\Control\Word('b', 0))->setIsSpaceDelimited(true),
            new Token\Text('bar'),
            new Token\Group\Close()
        ];

        $actual = (new Document())($this->stream('{\b foo \b0 bar}'));

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeReturnsArrayWhenContentIsNestedGroup(): void
    {
        $expected = [
            new Token\Group\Open(),
            (new Token\Control\Word('b'))->setIsSpaceDelimited(true),
            new Token\Group\Open(),
            (new Token\Control\Word('i'))->setIsSpaceDelimited(true),
            new Token\Text('foo'),
            new Token\Group\Close(),
            new Token\Group\Close(),
            new Token\Text(' bar')
        ];

        $actual = (new Document())($this->stream('{\b {\i foo}} bar'));

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeReturnsArrayWhenContentIsSmallDocument(): void
    {
        $content =
            '{'
                . '\rtf1\ansi\deff0'
                . '{'
                    . '\fonttbl'
                    . '{'
                        . '\f0\fnil\fcharset0 Courier New;'
                    . '}'
                . '}'
                . '{'
                    . '\*\generator Msftedit 5.41.15.1516;'
                . '}'
                . '\viewkind4\uc1\pard\lang1033\f0\fs20'
                . 'My dog is not like other dogs.\par'."\n"
                . 'He doesn\'t care to walk, \par'."\n"
                . 'He doesn\'t bark, he doesn\'t howl.\par'."\n"
                . 'He goes "Tick, tock. Tick, tock."\par'
            . '}';

        $expected = [
            new Token\Group\Open(),
            (new Token\Control\Word('rtf'))->setParameter(1)->setIsSpaceDelimited(false),
            (new Token\Control\Word('ansi'))->setIsSpaceDelimited(false),
            (new Token\Control\Word('deff'))->setParameter(0)->setIsSpaceDelimited(false),
            new Token\Group\Open(),
            (new Token\Control\Word('fonttbl'))->setIsSpaceDelimited(false),
            new Token\Group\Open(),
            (new Token\Control\Word('f', 0))->setParameter(0)->setIsSpaceDelimited(false),
            (new Token\Control\Word('fnil'))->setIsSpaceDelimited(false),
            (new Token\Control\Word('fcharset'))->setParameter(0)->setIsSpaceDelimited(true),
            new Token\Text('Courier New;'),
            new Token\Group\Close(),
            new Token\Group\Close(),
            new Token\Group\Open(),
            (new Token\Control\Symbol('*'))->setIsSpaceDelimited(false),
            (new Token\Control\Word('generator'))->setIsSpaceDelimited(true),
            new Token\Text('Msftedit 5.41.15.1516;'),
            new Token\Group\Close(),
            (new Token\Control\Word('viewkind'))->setParameter(4)->setIsSpaceDelimited(false),
            (new Token\Control\Word('uc'))->setParameter(1)->setIsSpaceDelimited(false),
            (new Token\Control\Word('pard'))->setIsSpaceDelimited(false),
            (new Token\Control\Word('lang'))->setParameter(1033)->setIsSpaceDelimited(false),
            (new Token\Control\Word('f'))->setParameter(0)->setIsSpaceDelimited(false),
            (new Token\Control\Word('fs'))->setParameter(20)->setIsSpaceDelimited(false),
            new Token\Text('My dog is not like other dogs.'),
            (new Token\Control\Word('par'))->setIsSpaceDelimited(false),
            new Token\Other("\n"),
            new Token\Text('He doesn\'t care to walk, '),
            (new Token\Control\Word('par'))->setIsSpaceDelimited(false),
            new Token\Other("\n"),
            new Token\Text('He doesn\'t bark, he doesn\'t howl.'),
            (new Token\Control\Word('par'))->setIsSpaceDelimited(false),
            new Token\Other("\n"),
            new Token\Text('He goes "Tick, tock. Tick, tock."'),
            (new Token\Control\Word('par'))->setIsSpaceDelimited(false),
            new Token\Group\Close()
        ];

        $actual = (new Document())($this->stream($content));

        $this->assertEquals($expected, $actual);
    }

    private function stream(string $content): Stream\Text
    {
        return new Stream\Text($content);
    }
}
