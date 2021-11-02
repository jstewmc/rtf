<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\{Group, Text};
use Jstewmc\Rtf\Style;

class CxdsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxds', (new Cxds())->getWord());
    }

    public function testRunDoesNothingWhenPreviousTextElementDoesNotEndWithSpace(): void
    {
        $word = new Cxds();
        $text = new Text('foo');

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text)
            ->appendChild($word)
            ->render();

        $this->assertEquals('foo', $text->getText());
    }

    public function testRunDoesNothingWhenNextTextElementDoesNotStartWithSpace(): void
    {
        $word = new Cxds();

        $text = new Text('foo');

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();

        $this->assertEquals('foo', $text->getText());
    }

    public function testRunDeletesSpaceWhenPreviousTextElementDoesEndWithSpace(): void
    {
        $word = new Cxds();
        $text = new Text('foo ');  // note the space

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text)
            ->appendChild($word)
            ->render();

        $this->assertEquals('foo', $text->getText());
    }

    public function testRunDeletesSpaceWhenNextTextElementDoesStartWithSpace(): void
    {
        $word = new Cxds();

        $text = new Text(' foo');  // note the space

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();

        $this->assertEquals('foo', $text->getText());
    }

    public function testRunDeletesSpaceWhenBothTextElementsHaveSpaces(): void
    {
        $word = new Cxds();

        $text1 = new Text('foo ');  // note the space
        $text2 = new Text(' bar');  // note the space

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text1)
            ->appendChild($word)
            ->appendChild($text2);

        $parent->render();

        $this->assertEquals('foobar', $parent->format('text'));
    }

    public function testRunDeletesSpaceWhenNeitherTextElementHasSpaces(): void
    {
        $word = new Cxds();

        $text1 = new Text('foo');
        $text2 = new Text('bar');

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text1)
            ->appendChild($word)
            ->appendChild($text2);

        $parent->render();

        $this->assertEquals('foobar', $parent->format('text'));
    }
}
