<?php

namespace Jstewmc\Rtf\State;

class CharacterTest extends \PHPUnit\Framework\TestCase
{
    public function testGetIsBoldReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsBold());
    }

    public function testSetIsBoldReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsBold(true));
    }

    public function testGetIsItalicReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsItalic());
    }

    public function testSetIsItalicReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsItalic(true));
    }

    public function testGetIsSubscriptReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsSubscript());
    }

    public function testSetIsSubscriptReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsSubscript(true));
    }

    public function testGetIsSuperscriptReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsSuperscript());
    }

    public function testSetIsSuperscriptReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsSuperscript(true));
    }

    public function testGetIsStrikethroughReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsStrikethrough());
    }

    public function testSetIsStrikethroughReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsStrikethrough(true));
    }

    public function testGetIsUnderlineReturnsBool(): void
    {
        $this->assertFalse((new Character())->getIsSubscript());
    }

    public function testSetIsUnderlineReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsSubscript(true));
    }

    public function testGetIsVisibleReturnsBool(): void
    {
        $this->assertTrue((new Character())->getIsVisible());
    }

    public function testSetIsVisibleReturnsSelf(): void
    {
        $state = new Character();

        $this->assertSame($state, $state->setIsVisible(true));
    }

    public function testFormatThrowsInvalidArgumentExceptionWhenFormatIsNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Character())->format('foo');
    }

    public function testFormatReturnsStringWhenFormatIsValid(): void
    {
        $this->assertEquals(
            'font-weight: bold; font-style: italic;',
            (new Character())->setIsBold(true)->setIsItalic(true)->format('css')
        );
    }
}
