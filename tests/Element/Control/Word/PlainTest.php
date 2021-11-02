<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class PlainTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('plain', (new Plain())->getWord());
    }

    public function testRunIncrementsParagraphIndex()
    {
        $style = new \Jstewmc\Rtf\Style();

        $old = $style->getCharacter()->getIsBold();

        $style->getCharacter()->setIsBold(! $old);

        $element = new Plain();
        $element->setStyle($style);
        $element->run();

        $new = $style->getCharacter()->getIsBold();

        $this->assertEquals($old, $new);

        return;
    }
}
