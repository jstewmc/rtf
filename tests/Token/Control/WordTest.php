<?php

use Jstewmc\Rtf\Token\Control\Word;
use Jstewmc\Stream;
use Jstewmc\Chunker;

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
	
	public function testGetSetIsSpaceDelimited()
	{
		$token = new Word();
		$token->setIsSpaceDelimited(true);
		
		$this->assertTrue($token->getIsSpaceDelimited());
		
		return;
		
	}
	
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
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return string if word does not exist
	 */
	public function testToString_returnsString_ifWordDoesNotExist()
	{
		$token = new Word();
		
		$expected = '';
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * __toString() should return string if word does exist
	 */
	public function testToString_returnsString_ifWordDoesExist()
	{
		$word = 'foo';
		
		$token = new Word($word);
		
		$expected = '\\foo ';
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * __toString() should return string if word and parameter exist
	 */
	public function testToString_returnsString_ifWordAndParameterDoExist()
	{
		$word = 'foo';
		$parameter = 1;
		
		$token = new Word($word, $parameter);
		
		$expected = '\\foo1 ';
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * __toString() should return string if control symbol is not space delimited
	 */
	public function testToString_returnsString_ifNotSpaceDelimited()
	{
		$token = new Word('foo');
		$token->setIsSpaceDelimited(false);
		
		$expected = '\\foo';
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !createFromStream() */
	
	/**
	 * createFromStream() should throw an InvalidArgumentException if the current
	 *     character in $stream is not a backslash
	 */
	public function testCreateFromStream_throwsInvalidArgumentException_ifCurrentCharacterIsNotBackslash()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$chunker = new Chunker\Text('foo');
		
		$stream = new Stream\Stream($chunker);
		
		Word::createFromStream($stream);
		
		return;
	}
	
	/**
	 * createFromStream() should throw an InvalidArgumentException if the next
	 *     character in $stream is not alphabetic
	 */
	public function testCreateFromStream_throwsInvalidArgumentException_ifNextCharacterIsNotAlphabetic()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$chunker = new Chunker\Text('\\1');
		
		$stream = new Stream\Stream($chunker);
		
		Word::createFromStream($stream);
		
		return;
	}
	
	/**
	 * createFromStream() should return false if $stream is empty
	 */
	public function testCreateFromStream_returnsFalse_ifCharactersIsEmpty()
	{
		$chunker = new Chunker\Text();
		
		$stream = new Stream\Stream($chunker);
		
		return $this->assertFalse(Word::createFromStream($stream));
	}
	
	/**
	 * createFromStream() should return false if the next character in $stream
	 *     is empty
	 */
	public function testCreateFromStream_returnsFalse_ifNextCharacterIsEmpty()
	{
		$chunker = new Chunker\Text('\\');
		
		$stream = new Stream\Stream($chunker);
		
		return $this->assertFalse(Word::createFromStream($stream));
	}
	
	/**
	 * createFromStream() should return a word token if a parameter does not exist and
	 *     the delimiter is the space character
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesNotExistAndDelimiterIsSpace()
	{
		$chunker = new Chunker\Text('\\foo bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertTrue($word->getIsSpaceDelimited());
		// $this->assertEquals(4, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a word token if a parameter does not exist and
	 *     the delimiter is not alphanumeric character
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesNotExistAndDelimiterIsCharacter()
	{
		$chunker = new Chunker\Text('\\foo+bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertFalse($word->getIsSpaceDelimited());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a word token if parameter does exist and it's a
	 *     positive number
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesExistAndPositive()
	{
		$chunker = new Chunker\Text('\\foo123 bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(123, $word->getParameter());
		// $this->assertEquals(7, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a word token if parameter does exist and it's a
	 *     negative number
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesExistAndNegative()
	{
		$chunker = new Chunker\Text('\\foo-123 bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(-123, $word->getParameter());
		// $this->assertEquals(8, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a word token if parameter does exist and it's 
	 *     delimited by a space
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesExistAndDelimiterIsSpace()
	{
		$chunker = new Chunker\Text('\\foo1 bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(1, $word->getParameter());
		$this->assertTrue($word->getIsSpaceDelimited());
		// $this->assertEquals(5, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a word token if parameter does exist and it's
	 *     delimited by any non-alphanumeric character
	 */
	public function testCreateFromStream_returnsToken_ifParameterDoesExistAndDelimiterIsCharacter()
	{
		$chunker = new Chunker\Text('\\foo1+bar');
		
		$stream = new Stream\Stream($chunker);
		
		$word = Word::createFromStream($stream);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('foo', $word->getWord());
		$this->assertEquals(1, $word->getParameter());
		$this->assertFalse($word->getIsSpaceDelimited());
		// $this->assertEquals(4, key($characters));
		
		return;
	}
}
