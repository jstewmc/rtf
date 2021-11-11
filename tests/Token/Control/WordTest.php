<?php

namespace Jstewmc\Rtf\Token\Control;

class WordTest extends \PHPUnit\Framework\TestCase
{
    public function testSetIsSpaceDelimitedReturnsSelf(): void
    {
        $word = new Word('foo');

        $this->assertSame($word, $word->setIsSpaceDelimited(true));
    }

    public function testGetIsSpaceDelimitedReturnsBoolean(): void
    {
        $this->assertTrue((new Word('foo'))->getIsSpaceDelimited());
    }

    public function testGetParameterReturnsNullWhenParameterDoesNotExist(): void
    {
        $this->assertNull((new Word('foo'))->getParameter());
    }

    public function testGetParameterReturnsIntWhenParameterDoesExist(): void
    {
        $this->assertEquals(1, (new Word('foo'))->setParameter(1)->getParameter());
    }

    public function testSetParameterReturnsSelf(): void
    {
        $symbol = new Word('foo');

        $this->assertSame($symbol, $symbol->setParameter(1));
    }

    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('foo', (new Word('foo'))->getWord());
    }

    public function testToStringReturnsStringWhenParameterDoesNotExist(): void
    {
        $this->assertEquals(
            '\\foo',
            (string)(new Word('foo'))->setIsSpaceDelimited(false)
        );
    }

    public function testToStringReturnsStringWhenParameterExists(): void
    {
        $this->assertEquals('\\foo1 ', (new Word('foo'))->setParameter(1));
    }

    public function testToStringReturnsStringWhenNotSpaceDelimited(): void
    {
        $this->assertEquals(
            '\\foo',
            (string)(new Word('foo'))->setIsSpaceDelimited(false)
        );
    }

    public function testHasParameterReturnsFalseWhenParameterDoesNotExist(): void
    {
        $this->assertFalse((new Word('foo'))->hasParameter());
    }

    public function testHasParameterReturnsTrueWhenParameterExists(): void
    {
        $this->assertTrue((new Word('foo'))->setParameter(1)->hasParameter());
    }
}
