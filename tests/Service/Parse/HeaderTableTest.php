<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Element;

class HeaderTableTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsGroupWhenHeaderTableDoesNotExist(): void
    {
        $root = $this->rootWithoutFontTable();

        $this->assertSame($root, (new HeaderTable())($root));
    }

    private function rootWithoutFontTable(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Text('foo'));
    }

    public function testInvokeReturnsGroupWhenFontTableExists(): void
    {
        $root = $this->rootWithFontTable();

        $root = (new HeaderTable())($root);

        $this->assertInstanceOf(Element\HeaderTable\FontTable::class, $root->getChild(3));
    }

    private function rootWithFontTable(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Control\Word\Deff(0))
            ->appendChild($this->fontTable())
            ->appendChild(new Element\Text('foo'));
    }

    private function fontTable(): Element\Group
    {
        // e.g., "{\fonttbl{\f0\fnil Bookman Old Style;}{\f1\fnil\fcharset0 Bookman Old Style;}}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Fonttbl())
            ->appendChild($this->f0Group())
            ->appendChild($this->f1Group());
    }

    private function f0Group(): Element\Group
    {
        // e.g., "{\f0\fnil Bookman Old Style;}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\F(0))
            ->appendChild(new Element\Control\Word\FontFamily\Fnil())
            ->appendChild(new Element\Text('Bookman Old Style;'));
    }

    private function f1Group(): Element\Group
    {
        // e.g., "{\f1\fnil\fcharset0 Bookman Old Style;}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\F(1))
            ->appendChild(new Element\Control\Word\FontFamily\Fnil())
            ->appendChild(new Element\Control\Word\Fcharset(0))
            ->appendChild(new Element\Text('Bookman Old Style;'));
    }

    public function testInvokeReturnsGroupWhenColorTableExists(): void
    {
        $root = $this->rootWithColorTable();

        $root = (new HeaderTable())($root);

        $this->assertInstanceOf(Element\HeaderTable\ColorTable::class, $root->getChild(3));
    }

    private function rootWithColorTable(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Control\Word\Deff(0))
            ->appendChild($this->colorTable())
            ->appendChild(new Element\Text('foo'));
    }

    private function colorTable(): Element\Group
    {
        // e.g., "{\colortbl;\red0\green0\blue0;\red0\green0\blue255;\red0\green255\blue255;}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Colortbl())
            ->appendChild(new Element\Text(';'))
            ->appendChild(new Element\Control\Word\Color\Red(0))
            ->appendChild(new Element\Control\Word\Color\Green(0))
            ->appendChild(new Element\Control\Word\Color\Blue(0))
            ->appendChild(new Element\Text(';'))
            ->appendChild(new Element\Control\Word\Color\Red(0))
            ->appendChild(new Element\Control\Word\Color\Green(0))
            ->appendChild(new Element\Control\Word\Color\Blue(255))
            ->appendChild(new Element\Text(';'))
            ->appendChild(new Element\Control\Word\Color\Red(0))
            ->appendChild(new Element\Control\Word\Color\Green(255))
            ->appendChild(new Element\Control\Word\Color\Blue(255));
    }

    public function testInvokeReturnsGroupWhenStylesheetExists(): void
    {
        $root = $this->rootWithStylesheet();

        $root = (new HeaderTable())($root);

        $this->assertInstanceOf(Element\HeaderTable\Stylesheet::class, $root->getChild(3));
    }

    private function rootWithStylesheet(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Control\Word\Deff(0))
            ->appendChild($this->stylesheet())
            ->appendChild(new Element\Text('foo'));
    }

    private function stylesheet(): Element\Group
    {
        // e.g., "{\stylesheet{\s0\snext0\widctlpar\hyphpar0\cf0 Normal;}}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Stylesheet())
            ->appendChild($this->s0Group());
    }

    private function s0Group(): Element\Group
    {
        // e.g., "{\s0\snext0\widctlpar\hyphpar0\cf0 Normal;}"
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\S(0))
            ->appendChild(new Element\Control\Word\Word('snext', 0))
            ->appendChild(new Element\Control\Word\Word('widctlpar'))
            ->appendChild(new Element\Control\Word\Word('hyphpar', 0))
            ->appendChild(new Element\Control\Word\Word('cf', 0))
            ->appendChild(new Element\Text('Normal;'));
    }
}
