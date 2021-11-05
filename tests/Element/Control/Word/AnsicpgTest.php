<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class AnsicpgTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWordReturnsString(): void
    {
        $this->assertEquals('ansicpg', (new Ansicpg(1))->getWord());
    }

    public function testGetEncodingReturnsStringWhenCodePageIsSupported(): void
    {
        $this->assertEquals('windows-1252', (new Ansicpg(1252))->getEncoding());
    }

    public function testGetEncodingReturnsStringWhenCodePageIsNotSupported(): void
    {
        $this->assertEquals('windows-999', (new Ansicpg(999))->getEncoding());
    }
}
