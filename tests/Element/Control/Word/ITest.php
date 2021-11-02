<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class ITest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('i', (new I())->getWord());
    }

    public function testRunDoesItalicizeWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new I();
        $element->setParameter('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsItalic());
    }

    public function testRunDoesNotItalicizeWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new I();
        $element->setParameter('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());
    }
}
