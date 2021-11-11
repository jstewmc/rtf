<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class QmspaceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('qmspace', (new Qmspace())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $this->assertEquals('&thinsp;', (new Qmspace())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText()
    {
        $this->assertEquals(
            html_entity_decode('&thinsp;'),
            (new Qmspace())->format('text')
        );
    }
}
