<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\{Group, Text};
use Jstewmc\Rtf\Style;

class CxflTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('cxfl', (new Cxfl())->getWord());
    }

    public function testRunLowerCasesFirstCharacterWhenNextTextElementDoesExist(): void
    {
        $word = new Cxfl();
        $text = new Text('FOO');  // note the upper-case

        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();

        $this->assertEquals('fOO', $text->getText());
    }
}
