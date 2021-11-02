<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class VTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('v', (new V())->getWord());
    }

    public function testRunDoesShowWhenParameterIsOmitted(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new V();
        $element->setStyle($style);

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());

        return;
    }

    public function testRunDoesShowWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new V('1');
        $element->setStyle($style);

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());

        return;
    }

    public function testRunDoesNotShowWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new V('0');
        $element->setStyle($style);

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsVisible());

        return;
    }
}
