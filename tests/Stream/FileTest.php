<?php

namespace Jstewmc\Rtf\Stream;

use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};

class FileTest extends \PHPUnit\Framework\TestCase
{
    private vfsStreamDirectory $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('root');
    }

    public function testIsOnLiteralReturnsFalseWhenNotOnLiteral(): void
    {
        $this->assertFalse($this->stream('foo')->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedGroupOpen(): void
    {
        $this->assertTrue($this->stream('\\{')->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedGroupClose(): void
    {
        $this->assertTrue($this->stream('\\}')->isOnLiteral());
    }

    public function testIsOnLiteralReturnsTrueWhenOnEscapedBackslash(): void
    {
        $this->assertTrue($this->stream('\\\\')->isOnLiteral());
    }

    public function testIsOnImplicitParagraphReturnsFalseWhenNotOnImplicitParagraph(): void
    {
        $this->assertFalse($this->stream('foo')->isOnImplicitParagraph());
    }

    public function testIsOnImplicitParagraphReturnsTrueWhenOnEscapedCarriageReturn(): void
    {
        $this->assertTrue($this->stream("\\\r")->isOnImplicitParagraph());
    }

    public function testIsOnImplicitParagraphReturnsTrueWhenOnEscapedNewLine(): void
    {
        $this->assertTrue($this->stream("\\\n")->isOnImplicitParagraph());
    }

    public function testIsOnControlWordReturnsFalseWhenNotOnControlWord(): void
    {
        $this->assertFalse($this->stream('foo')->isOnControlWord());
    }

    public function testIsOnControlWordReturnsTrueWhenOnControlWord(): void
    {
        $this->assertTrue($this->stream('\\foo')->isOnControlWord());
    }

    public function testIsOnControlSymbolReturnsFalseWhenNotOnControlSymbol(): void
    {
        $this->assertFalse($this->stream('foo')->isOnControlSymbol());
    }

    public function testIsOnControlSymbolReturnsTrueWhenOnControlSymbol(): void
    {
        $this->assertTrue($this->stream('\\*')->isOnControlSymbol());
    }

    public function testIsOnGroupOpenReturnsFalseWhenNotOnGroupOpen(): void
    {
        $this->assertFalse($this->stream('foo')->isOnGroupOpen());
    }

    public function testIsOnGroupOpenReturnsTrueWhenOnGroupOpen(): void
    {
        $this->assertTrue($this->stream('{')->isOnGroupOpen());
    }

    public function testIsOnGroupCloseReturnsFalseWhenNotOnGroupOpen(): void
    {
        $this->assertFalse($this->stream('foo')->isOnGroupClose());
    }

    public function testIsOnGroupCloseReturnsTrueWhenOnGroupClose(): void
    {
        $this->assertTrue($this->stream('}')->isOnGroupClose());
    }

    public function testIsOnTabReturnsFalseWhenNotOnTab(): void
    {
        $this->assertFalse($this->stream('foo')->isOnTab());
    }

    public function testIsOnTabReturnsTrueWhenOnTab(): void
    {
        $this->assertTrue($this->stream("\t")->isOnTab());
    }

    public function testIsOnBackslashReturnsFalseWhenNotOnBackslash(): void
    {
        $this->assertFalse($this->stream('foo')->isOnBackslash());
    }

    public function testIsOnBackslashReturnsTrueWhenOnBackslash(): void
    {
        $this->assertTrue($this->stream('\\')->isOnBackslash());
    }

    public function testIsOnOtherReturnsFalseWhenNotOnOther(): void
    {
        $this->assertFalse($this->stream('foo')->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnCarriageReturn(): void
    {
        $this->assertTrue($this->stream("\r")->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnNewline(): void
    {
        $this->assertTrue($this->stream("\n")->isOnOther());
    }

    public function testIsOnOtherReturnsTrueWhenOnFormFeed(): void
    {
        $this->assertTrue($this->stream("\f")->isOnOther());
    }

    public function testIsOnDigitReturnsFalseWhenNotOnDigit(): void
    {
        $this->assertFalse($this->stream('foo')->isOnDigit());
    }

    public function testIsOnDigitReturnsTrueWhenOnDigit(): void
    {
        $this->assertTrue($this->stream('1')->isOnDigit());
    }

    public function testIsOnHyphenReturnsFalseWhenNotOnHyphen(): void
    {
        $this->assertFalse($this->stream('foo')->isOnHyphen());
    }

    public function testIsOnHyphenReturnsTrueWhenOnHyphen(): void
    {
        $this->assertTrue($this->stream('-')->isOnHyphen());
    }

    public function testIsOnAlphabeticReturnsFalseWhenNotOnAlphabetic(): void
    {
        $this->assertFalse($this->stream('123')->isOnAlphabetic());
    }

    public function testIsOnAlphabeticReturnsTrueWhenOnAlphabetic(): void
    {
        $this->assertTrue($this->stream('foo')->isOnAlphabetic());
    }

    public function testIsOnSpaceReturnsFalseWhenNotOnSpace(): void
    {
        $this->assertFalse($this->stream('foo')->isOnSpace());
    }

    public function testIsOnSpaceReturnsTrueWhenOnSpace(): void
    {
        $this->assertTrue($this->stream(' ')->isOnSpace());
    }

    public function testIsOnApostropheReturnsFalseWhenNotOnApostrophe(): void
    {
        $this->assertFalse($this->stream('foo')->isOnApostrophe());
    }

    public function testIsOnApostropheReturnsTrueWhenOnApostrophe(): void
    {
        $this->assertTrue($this->stream('\'')->isOnApostrophe());
    }

    private function file(string $content): vfsStreamFile
    {
        return vfsStream::newFile('example.txt')
            ->withContent($content)
            ->at($this->root);
    }

    private function stream(string $content): File
    {
        return new File($this->file($content)->url());
    }
}
