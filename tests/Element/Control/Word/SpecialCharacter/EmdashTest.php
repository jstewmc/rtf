<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class EmdashTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('emdash', (new Emdash())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&emdash;', (new Emdash())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&emdash;'),
            (new Emdash())->format('text')
        );
    }
}
