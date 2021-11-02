<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class PardTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('pard', (new Pard())->getWord());
    }

    public function testRunResetsParagraphState(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $old = $style->getParagraph()->getIndex();

        $style->getParagraph()->setIndex(999);

        $element = new Pard();
        $element->setStyle($style);
        $element->run();

        $new = $style->getParagraph()->getIndex();

        $this->assertEquals($old, $new);

        return;
    }
}
