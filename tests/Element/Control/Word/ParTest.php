<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class ParTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('par', (new Par())->getWord());
    }

    public function testRunIncrementsParagraphIndex(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $old = $style->getParagraph()->getIndex();

        $element = new Par();
        $element->setStyle($style);
        $element->run();

        $new = $style->getParagraph()->getIndex();

        $this->assertGreaterThan($old, $new);

        return;
    }
}
