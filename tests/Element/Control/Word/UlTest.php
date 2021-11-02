<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class UlTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ul', (new Ul())->getWord());
    }

    public function testRunDoesUnderlineWhenParameterIsOmitted(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Ul();
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());
    }

    public function testRunDoesUnderlineWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Ul('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());
    }

    public function testRunDoesNotUnderlineWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Ul('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
    }
}
