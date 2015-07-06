<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the word class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class WordTest extends \PHPUnit_Framework_TestCase
{
	/* !setIsIgnored() / getIsIgnored() */
	
	/**
	 * setIsIgnored() and getIsIgnored() should set and get the control word's is-
	 *     ignored property, respectively
	 */
	public function testSetGetIsIgnored()
	{
		$isIgnored = true;
		
		$word = new Word();
		$word->setIsIgnored($isIgnored);
		
		$expected = $isIgnored;
		$actual   = $word->getIsIgnored();
		
		$this->assertEquals($expected, $actual);
		
		return;	
	}
	
	
	/* !setWord()/getWord() */
	
	/**
	 * setWord() and getWord() should set and get the control word's word, respectively
	 */
	public function testSetGetWord()
	{
		$string = 'foo';
		
		$word = new Word();
		$word->setWord($string);
		
		$expected = $string;
		$actual   = $word->getWord();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !setParameter()/getParameter() */

	/**
	 * setWord() and getWord() should set and get the control word's parameter, respectively
	 */
	public function testSetGetParameter()
	{
		$parameter = 1;
		
		$word = new Word();
		$word->setParameter($parameter);
		
		$expected = $parameter;
		$actual   = $word->getParameter();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !__construct() */
	
	/**
	 * __construct() should return word element if $parameter is null
	 */
	public function testConstruct_returnsElement_ifParameterIsNull()
	{
		$word = new Word();
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('word', $word->getWord());
		$this->assertNull($word->getParameter());
		
		return;
	}
	
	/**
	 * __construct() should return word element if parameter is not null
	 */
	public function testConstruct_returnsElement_ifParameterIsNotNull()
	{
		$parameter = 1;
		
		$word = new Word($parameter);
		
		$this->assertTrue($word instanceof Word);
		$this->assertEquals('word', $word->getWord());
		$this->assertEquals($parameter, $word->getParameter());
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return string if not space delimited
	 */
	public function testToString_returnsString_ifNotSpaceDelimited()
	{
		$word = new Word();
		$word->setWord('b');
		$word->setIsSpaceDelimited(false);
		
		$this->assertEquals('\\b', (string) $word);
		
		return;
	}
	
	/**
	 * __toString() should return string if the control word is ignored
	 */
	public function testToString_returnsString_ifIsIgnored()
	{
		$word = new Word();
		$word->setWord('b');
		$word->setIsIgnored(true);
		
		$this->assertEquals('\\*\\b ', (string) $word);
		
		return;
	}
	
	/**
	 * __toString() should return string if parameter does not exist
	 */
	public function testToString_returnsString_ifParameterDoesNotExist()
	{
		$word = new Word();
		$word->setWord('b');
		
		$this->assertEquals('\\b ', (string) $word);
		
		return;
	}
	
	/**
	 * __toString() should return string if parameter does exist
	 */
	public function testToString_returnsString_ifParameterDoesExist()
	{
		$word = new Word();
		$word->setWord('b');
		$word->setParameter(0);
		
		$this->assertEquals('\\b0 ', (string) $word);
		
		return;
	}
}
