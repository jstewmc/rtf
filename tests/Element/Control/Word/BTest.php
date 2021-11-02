<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class BTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('b', (new B())->getWord());
    }

    public function testRunDoesBoldWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new B();
        $element->setParameter('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsBold());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsBold());

        return;
    }

    public function testRunDoesNotBoldWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new B();
        $element->setParameter('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsBold());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsBold());

        return;
    }
}
