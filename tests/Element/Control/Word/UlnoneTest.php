<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class UlnoneTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ulnone', (new Ulnone())->getWord());
    }

    public function testRunDoesNotUnderline(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $style->getCharacter()->setIsUnderline(true);

        $element = new Ulnone();
        $element->setStyle($style);

        $this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
    }
}
