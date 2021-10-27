<?php

namespace Jstewmc\Rtf\Token;

class OtherTest extends \PHPUnit\Framework\TestCase
{
    public function testToStringReturnsString(): void
    {
        $this->assertEquals("\n", (string)(new Other("\n")));
    }

    public function testGetCharacterReturnsString(): void
    {
        $this->assertEquals("\n", (new Other("\n"))->getCharacter());
    }
}
