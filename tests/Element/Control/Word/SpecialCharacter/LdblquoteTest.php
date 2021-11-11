<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class LdblquoteTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ldblquote', (new Ldblquote())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&ldquo;', (new Ldblquote())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&ldquo;'),
            (new Ldblquote())->format('text')
        );
    }
}
