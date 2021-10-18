<?php

namespace Jstewmc\Rtf\Token;

/**
 * A test suite for the Token\Other class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.3.0
 */

class OtherTest extends \PHPUnit\Framework\TestCase
{
    /* !__construct() */

    /**
     * __construct() should return token if character does not exist
     */
    public function testConstructReturnsTokenWhenCharacterDoesNotExist()
    {
        $token = new Other();

        $this->assertTrue($token instanceof Other);
        $this->assertNull($token->getCharacter());

        return;
    }

    /**
     * __construct() should return token if character does exist
     */
    public function testConstructReturnsTokenWhenCharacterDoesExist()
    {
        $character = "\n";

        $token = new Other($character);

        $this->assertTrue($token instanceof Other);
        $this->assertEquals($character, $token->getCharacter());

        return;
    }


    /* !__toString() */

    /**
     * __toString() should return string if character does not exist
     */
    public function testToStringReturnsStringWhenCharacterDoesNotExist()
    {
        $token = new Other();

        $this->assertEquals('', (string)$token);

        return;
    }

    /**
     * __toString() should return string if character does exist
     */
    public function testToStringReturnsStringWhenCharacterDoesExist()
    {
        $character = "\n";

        $token = new Other();
        $token->setCharacter($character);

        $this->assertEquals("\n", (string)$token);

        return;
    }


    /* !getCharacter() */

    /**
     * getCharacter() should return null if character does not exist
     */
    public function testGetCharacterReturnsNullWhenCharacterDoesNotExist()
    {
        $token = new Other();

        $this->assertNull($token->getCharacter());

        return;
    }

    /**
     * getCharacter() should return character is character does exist
     */
    public function testGetCharacterReturnsCharacterWhenCharacterDoesExist()
    {
        $character = "\n";

        $token = new Other();
        $token->setCharacter($character);

        $this->assertEquals($character, $token->getCharacter());

        return;
    }


    /* !setCharacter() */

    /**
     * setCharacter() should set the token's character and return self
     */
    public function testSetCharacter()
    {
        $character = "\n";

        $token = new Other();

        $expected = $token;
        $actual   = $token->setCharacter($character);

        $this->assertSame($expected, $actual);

        $expected = $character;
        $actual   = $token->getCharacter();

        $this->assertEquals($expected, $actual);

        return;
    }
}
