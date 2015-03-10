<?php

use Jstewmc\Rtf\Token\Control\Word;

/**
 * A test suite for the control word class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class WordTest extends PHPUnit_Framework_Testcase
{	
	/* !Get/set methods */
	
	public function testGetSetParameter()
	{
		$parameter = 1;
		
		$token = new Word();
		$token->setParameter($parameter);
		
		$expected = $parameter;
		$actual   = $token->getParameter();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	public function testGetSetWord()
	{
		$word = 'foo';
		
		$token = new Word();
		$token->setWord($word);
		
		$expected = $word;
		$actual   = $token->getWord();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}	
	
	
	/* !__construct() */
	
	
	/* !createFromSource() */
	
	/**
	 * createFromSource() should throw an InvalidArgumentException if the current
	 *     character in $characters is not a backslash
	 */
	public function testCreateFromSource_throwsInvalidArgumentException_ifCurrentCharacterIsNotBackslash()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$characters = ['f', 'o', 'o'];
		
		Word::createFromSource($characters);
		
		return;
	}
	
	/**
	 * createFromSource() should throw an InvalidArgumentException if the next
	 *     character in $characters is not alphabetic
	 */
	public function testCreateFromSource_throwsInvalidArgumentException_ifNextCharacterIsNotAlphabetic()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$characters = ['\\', '1'];
		
		Word::createFromSource($characters);
		
		return;
	}
	
	/**
	 * createFromSource() should return false if $characters is empty
	 */
	public function testCreateFromSource_returnsFalse_ifCharactersIsEmpty()
	{
		$characters = [];
		
		return $this->assertFalse(Word::createFromSource($characters));
	}
	
	/**
	 * createFromSource() should return false if the next character in $characters
	 *     is empty
	 */
	public function testCreateFromSource_returnsFalse_ifNextCharacterIsEmpty()
	{
		$characters = ['\\'];
		
		return $this->assertFalse(Word::createFromSource($characters));
	}
	
	/**
	 * createFromSource() should return a word token if a parameter does not exist and
	 *     the delimiter is the space character
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesNotExistAndDelimiterIsSpace()
	{
		
		$characters = ['\\', 'f', 'o', 'o', ' ', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(4, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a word token if a parameter does not exist and
	 *     the delimiter is not alphanumeric character
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesNotExistAndDelimiterIsCharacter()
	{
		$characters = ['\\', 'f', 'o', 'o', '+', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a word token if parameter does exist and it's a
	 *     positive number
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesExistAndPositive()
	{
		$characters = ['\\', 'f', 'o', 'o', '1', '2', '3', ' ', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(123, $word->getParameter());
		$this->assertEquals(7, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a word token if parameter does exist and it's a
	 *     negative number
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesExistAndNegative()
	{
		$characters = ['\\', 'f', 'o', 'o', '-', '1', '2', '3', ' ', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(-123, $word->getParameter());
		$this->assertEquals(8, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a word token if parameter does exist and it's 
	 *     delimited by a space
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesExistAndDelimiterIsSpace()
	{
		$characters = ['\\', 'f', 'o', 'o', '1', ' ', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(1, $word->getParameter());
		$this->assertEquals(5, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a word token if parameter does exist and it's
	 *     delimited by any non-alphanumeric character
	 */
	public function testCreateFromSource_returnsToken_ifParameterDoesExistAndDelimiterIsCharacter()
	{
		$characters = ['\\', 'f', 'o', 'o', '1', '+', 'b', 'a', 'r'];
		
		$word = Word::createFromSource($characters);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(1, $word->getParameter());
		$this->assertEquals(4, key($characters));
		
		return;
	}
}
