<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\{Group, Text};
use Jstewmc\Rtf\Style;

class CxfcTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxfc', (new Cxfc())->getWord());
    }

    public function testRunUpperCasesFirstCharacterWhenNextTextElementDoesExist(): void
    {
        $word = new Cxfc();
        $text = new Text('foo');  // note the lower-case

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();

        $this->assertEquals('Foo', $text->getText());
    }
}
