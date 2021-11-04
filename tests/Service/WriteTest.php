<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

class WriteTest extends \PHPUnit\Framework\TestCase
{
    public function testWriteThrowsInvalidArgumentExceptionWhenFormatIsNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Write())(new Element\Group(), 'foo');
    }

    public function testWriteReturnsStringWhenElementsDoNotExist(): void
    {
        $this->assertEquals('{}', (new Write())(new Element\Group()));
    }

    public function testWriteReturnsStringWhenElementsDoExist(): void
    {
        $group = (new Element\Group())
            ->appendChild(new Element\Text('foo '))
            ->appendChild((new Element\Group())
                ->appendChild(new Element\Control\Word\B())
                ->appendChild(new Element\Text('bar'))
                ->appendChild(new Element\Control\Word\B(0)));

        $root = (new Render())($group);

        $this->assertEquals('{foo {\b bar\b0 }}', (new Write())($root));
    }

    public function testWriteReturnsStringWhenFormatIsHtml(): void
    {
        $group = (new Element\Group())
            ->appendChild(new Element\Text('foo '))
            ->appendChild((new Element\Group())
                ->appendChild(new Element\Control\Word\B())
                ->appendChild(new Element\Text('bar'))
                ->appendChild(new Element\Control\Word\B(0)));

        $root = (new Render())($group);

        $expected = '<section style=""><p style=""><span style="">foo </span>'
            . '<span style="font-weight: bold;">bar</span></p></section>';
        $actual = (new Write())($root, 'html');

        $this->assertEquals($expected, $actual);
    }

    public function testWriteReturnsStringWhenFormatIsRtf(): void
    {
        $group = (new Element\Group())
            ->appendChild(new Element\Text('foo '))
            ->appendChild((new Element\Group())
                ->appendChild(new Element\Control\Word\B())
                ->appendChild(new Element\Text('bar'))
                ->appendChild(new Element\Control\Word\B(0)));

        $root = (new Render())($group);

        $this->assertEquals('{foo {\b bar\b0 }}', (new Write())($root, 'rtf'));
    }

    public function testWriteReturnsStringWhenFormatIsText()
    {
        $group = (new Element\Group())
            ->appendChild(new Element\Text('foo '))
            ->appendChild((new Element\Group())
                ->appendChild(new Element\Control\Word\B())
                ->appendChild(new Element\Text('bar'))
                ->appendChild(new Element\Control\Word\B(0)));

        $root = (new Render())($group);

        $this->assertEquals('foo bar', (new Write())($root, 'text'));
    }
}
