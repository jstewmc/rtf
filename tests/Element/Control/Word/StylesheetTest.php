<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class StylesheetTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('stylesheet', (new Stylesheet())->getWord());
    }
}
