<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class SubTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('sub', (new Sub())->getWord());
    }

    public function testRunDoesSubscriptWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Sub('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsSubscript());
    }

    public function testRunDoesNotSubscriptWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Sub('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());
    }
}
