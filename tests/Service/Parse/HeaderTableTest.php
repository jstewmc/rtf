<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Element;

class HeaderTableTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsGroupWhenFontTableDoesNotExist(): void
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

    public function testInvokeReturnsGroupWhenFontTableDoesExist(): void
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
}
