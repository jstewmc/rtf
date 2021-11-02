<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class WordTest extends \PHPUnit\Framework\TestCase
{
    public function testGetIsIgnoredReturnsBool(): void
    {
        $this->assertFalse((new Word('foo'))->getIsIgnored());
    }

    public function testSetIsIgnoredReturnsSelf(): void
    {
        $word = new Word('foo');

        $this->assertSame($word, $word->setIsIgnored(true));
    }

    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('foo', (new Word('foo'))->getWord());
    }

    public function testGetParameterReturnsInt(): void
    {
        $this->assertEquals(1, (new Word('foo', 1))->getParameter());
    }

    public function testSetParameterReturnsSelf(): void
    {
        $word = new Word('foo');

        $this->assertSame($word, $word->setParameter(1));
    }

    public function testToStringReturnsStringWhenNotSpaceDelimited(): void
    {
        $this->assertEquals('\\b', (string)(new Word('b'))->setIsSpaceDelimited(false));
    }

    public function testToStringReturnsStringWhenIsIgnored(): void
    {
        $this->assertEquals('\\*\\b ', (string)(new Word('b'))->setIsIgnored(true));
    }

    public function testToStringReturnsStringWhenParameterDoesNotExist(): void
    {
        $this->assertEquals('\\b ', (string)(new Word('b')));
    }

    public function testToStringReturnsStringWhenParameterDoesExist()
    {
        $this->assertEquals('\\b0 ', (string)(new Word('b', 0)));
    }
}
