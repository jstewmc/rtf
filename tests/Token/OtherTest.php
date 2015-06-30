<?php
	
use Jstewmc\Rtf\Token;
use Jstewmc\Stream;

/**
 * A test suite for the Token\Other class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.3.0
 */

class OtherTest extends PHPUnit_Framework_Testcase
{
	/* !__construct() */
	
	/**
	 * __construct() should return token if character does not exist
	 */
	public function testConstruct_returnsToken_ifCharacterDoesNotExist()
	{
		$token = new Token\Other();
		
		$this->assertTrue($token instanceof Token\Other);
		$this->assertNull($token->getCharacter());
		
		return;
	}
	
	/**
	 * __construct() should return token if character does exist
	 */
	public function testConstruct_returnsToken_ifCharacterDoesExist()
	{
		$character = "\n";
		
		$token = new Token\Other($character);
		
		$this->assertTrue($token instanceof Token\Other);
		$this->assertEquals($character, $token->getCharacter());
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return string if character does not exist
	 */
	public function testToString_returnsString_ifCharacterDoesNotExist()
	{
		$token = new Token\Other();
		
		$this->assertEquals('', (string) $token);
		
		return;
	} 
	
	/**
	 * __toString() should return string if character does exist
	 */
	public function testToString_returnsString_ifCharacterDoesExist()
	{
		$character = "\n";
		
		$token = new Token\Other();
		$token->setCharacter($character);
		
		$this->assertEquals("\n", (string) $token);
		
		return;
	}
	
	
	/* !getCharacter() */
	
	/**
	 * getCharacter() should return null if character does not exist
	 */
	public function testGetCharacter_returnsNull_ifCharacterDoesNotExist()
	{
		$token = new Token\Other();
		
		$this->assertNull($token->getCharacter());
		
		return;
	}
	
	/**
	 * getCharacter() should return character is character does exist
	 */
	public function testGetCharacter_returnsCharacter_ifCharacterDoesExist()
	{
		$character = "\n";
		
		$token = new Token\Other();
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
		
		$token = new Token\Other();
		
		$expected = $token;
		$actual   = $token->setCharacter($character);
		
		$this->assertSame($expected, $actual);
		
		$expected = $character;
		$actual   = $token->getCharacter();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
