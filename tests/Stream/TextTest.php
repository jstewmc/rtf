<?php

namespace Jstewmc\Rtf\Stream;

class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testIsOnLiteralReturnsFalseWhenNotOnLiteral(): void
    {
        $this->assertFalse((new Text('foo'))->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedGroupOpen(): void
    {
        $this->assertTrue((new Text('\\{'))->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedGroupClose(): void
    {
        $this->assertTrue((new Text('\\}'))->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedBackslash(): void
    {
        $this->assertTrue((new Text('\\\\'))->isOnLiteral());
    }

    public function testIsOnImplicitParagraphReturnsFalseWhenNotOnImplicitParagraph(): void
    {
        $this->assertFalse((new Text('foo'))->isOnImplicitParagraph());
    }

    public function testIsOnImplicitParagraphReturnsTrueWhenOnEscapedCarriageReturn(): void
    {
        $this->assertTrue((new Text("\\\r"))->isOnImplicitParagraph());
    }

    public function testIsOnImplicitParagraphReturnsTrueWhenOnEscapedNewLine(): void
    {
        $this->assertTrue((new Text("\\\n"))->isOnImplicitParagraph());
    }

    public function testIsOnControlWordReturnsFalseWhenNotOnControlWord(): void
    {
        $this->assertFalse((new Text('foo'))->isOnControlWord());
    }

    public function testIsOnControlWordReturnsTrueWhenOnControlWord(): void
    {
        $this->assertTrue((new Text('\\foo'))->isOnControlWord());
    }

    public function testIsOnControlSymbolReturnsFalseWhenNotOnControlSymbol(): void
    {
        $this->assertFalse((new Text('foo'))->isOnControlSymbol());
    }

    public function testIsOnControlSymbolReturnsTrueWhenOnControlSymbol(): void
    {
        $this->assertTrue((new Text('\\*'))->isOnControlSymbol());
    }

    public function testIsOnGroupOpenReturnsFalseWhenNotOnGroupOpen(): void
    {
        $this->assertFalse((new Text('foo'))->isOnGroupOpen());
    }

    public function testIsOnGroupOpenReturnsTrueWhenOnGroupOpen(): void
    {
        $this->assertTrue((new Text('{'))->isOnGroupOpen());
    }

    public function testIsOnGroupCloseReturnsFalseWhenNotOnGroupOpen(): void
    {
        $this->assertFalse((new Text('foo'))->isOnGroupClose());
    }

    public function testIsOnGroupCloseReturnsTrueWhenOnGroupClose(): void
    {
        $this->assertTrue((new Text('}'))->isOnGroupClose());
    }

    public function testIsOnTabReturnsFalseWhenNotOnTab(): void
    {
        $this->assertFalse((new Text('foo'))->isOnTab());
    }

    public function testIsOnTabReturnsTrueWhenOnTab(): void
    {
        $this->assertTrue((new Text("\t"))->isOnTab());
    }

    public function testIsOnBackslashReturnsFalseWhenNotOnBackslash(): void
    {
        $this->assertFalse((new Text('foo'))->isOnBackslash());
    }

    public function testIsOnBackslashReturnsTrueWhenOnBackslash(): void
    {
        $this->assertTrue((new Text('\\'))->isOnBackslash());
    }

    public function testIsOnOtherReturnsFalseWhenNotOnOther(): void
    {
        $this->assertFalse((new Text('foo'))->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnCarriageReturn(): void
    {
        $this->assertTrue((new Text("\r"))->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnNewline(): void
    {
        $this->assertTrue((new Text("\n"))->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnFormFeed(): void
    {
        $this->assertTrue((new Text("\f"))->isOnOther());
    }

    public function testIsOnDigitReturnsFalseWhenNotOnDigit(): void
    {
        $this->assertFalse((new Text('foo'))->isOnDigit());
    }

    public function testIsOnDigitReturnsTrueWhenOnDigit(): void
    {
        $this->assertTrue((new Text('1'))->isOnDigit());
    }

    public function testIsOnHyphenReturnsFalseWhenNotOnHyphen(): void
    {
        $this->assertFalse((new Text('foo'))->isOnHyphen());
    }

    public function testIsOnHyphenReturnsTrueWhenOnHyphen(): void
    {
        $this->assertTrue((new Text('-'))->isOnHyphen());
    }

    public function testIsOnAlphabeticReturnsFalseWhenNotOnAlphabetic(): void
    {
        $this->assertFalse((new Text('123'))->isOnAlphabetic());
    }

    public function testIsOnAlphabeticReturnsTrueWhenOnAlphabetic(): void
    {
        $this->assertTrue((new Text('foo'))->isOnAlphabetic());
    }

    public function testIsOnSpaceReturnsFalseWhenNotOnSpace(): void
    {
        $this->assertFalse((new Text('foo'))->isOnSpace());
    }

    public function testIsOnSpaceReturnsTrueWhenOnSpace(): void
    {
        $this->assertTrue((new Text(' '))->isOnSpace());
    }

    public function testIsOnApostropheReturnsFalseWhenNotOnApostrophe(): void
    {
        $this->assertFalse((new Text('foo'))->isOnApostrophe());
    }

    public function testIsOnApostropheReturnsTrueWhenOnApostrophe(): void
    {
        $this->assertTrue((new Text('\''))->isOnApostrophe());
    }
}
