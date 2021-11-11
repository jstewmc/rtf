<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

class DetectEncodingTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsDefaultWhenVersionIsMissing(): void
    {
        $this->assertEquals(
            'windows-1252',
            (new DetectEncoding())($this->groupWithoutVersion())
        );
    }

    private function groupWithoutVersion(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\B())
            ->appendChild(new Element\Text('foo'))
            ->appendChild(new Element\Control\Word\B(0));
    }

    public function testInvokeReturnsDefaultWhenCharacterSetIsMissing(): void
    {
        $this->assertEquals(
            'windows-1252',
            (new DetectEncoding())($this->groupWithoutCharacterSet())
        );
    }

    private function groupWithoutCharacterSet(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Text('foo'));
    }

    public function testInvokeReturnsStringWhenCodePageIsMissing(): void
    {
        $this->assertEquals(
            'windows-1252',
            (new DetectEncoding())($this->groupWithoutCodePage())
        );
    }

    private function groupWithoutCodePage(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Ansi())
            ->appendChild(new Element\Text('foo'));
    }

    public function testInvokeReturnsStringWhenEncodingIsFromCharacterSet(): void
    {
        $this->assertEquals(
            'macintosh',
            (new DetectEncoding())($this->groupWithCharacterSetEncoding())
        );
    }

    private function groupWithCharacterSetEncoding(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Control\Word\Ansicpg(1))
            ->appendChild(new Element\Text('foo'));
    }

    public function testInvokeReturnsStringWhenEncodingIsFromCodePage(): void
    {
        $this->assertEquals(
            'ISO-8859-6',
            (new DetectEncoding())($this->groupWithCodePageEncoding())
        );
    }

    private function groupWithCodePageEncoding(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Ansi())
            ->appendChild(new Element\Control\Word\Ansicpg(708))
            ->appendChild(new Element\Text('foo'));
    }

    public function testInvokeReturnsStringWhenEncodingIsAnsiWithoutCodePage(): void
    {
        $this->assertEquals(
            'windows-1252',
            (new DetectEncoding())($this->groupWithAnsiWithoutCodePage())
        );
    }

    private function groupWithAnsiWithoutCodePage(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Ansi());
    }
}
