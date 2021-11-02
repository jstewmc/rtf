<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class StrikeTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('strike', (new Strike())->getWord());
    }

    public function testRunDoesStrikethroughWhenParameterIsNotZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Strike('1');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());

        $element->run();

        $this->assertTrue($element->getStyle()->getCharacter()->getIsStrikethrough());
    }

    public function testRunDoesNotStrikethroughWhenParameterIsZero(): void
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Strike('0');
        $element->setStyle($style);

        $this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());

        $element->run();

        $this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());
    }
}
