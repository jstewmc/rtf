<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

class PcaTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('pca', (new Pca())->getWord());
    }

    public function testGetEncodingReturnsString(): void
    {
        $this->assertEquals('IBM850', (new Pca())->getEncoding());
    }
}
