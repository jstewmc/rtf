<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class BulletTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('bullet', (new Bullet())->getWord());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('&bull;', (new Bullet())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals(
            html_entity_decode('&bull;'),
            (new Bullet())->format('text')
        );
    }
}
