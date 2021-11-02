<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class SuperTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('super', (new Super())->getWord());
    }

    public function testRunDoesSuperscriptWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Super('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsSuperscript());
    }

    public function testRunDoesNotSuperscriptWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Super('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());
    }
}
