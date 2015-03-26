<?php

use Jstewmc\Rtf\Token\Control\Symbol;
use Jstewmc\Stream;

/**
 * A test suite for the control symbol class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class SymbolTest extends PHPUnit_Framework_Testcase
{	
	/* !Get/set methods */
	
	/**
	 * setParameter() and getParameter() should get and set the parameter
	 */
	public function testSetAndGetParameter()
	{
		$parameter = 'b';
		
		$symbol = new Symbol();
		$symbol->setParameter($parameter);
		
		$expected = $parameter;
		$actual   = $symbol->getParameter();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * setSymbol() and getSymbol() should, well, get and set the symbol
	 */
	public function testSetAndGetSymbol()
	{
		$symbol = '+';
		
		$symbol = new Symbol();
		$symbol->setSymbol($symbol);
		
		$expected = $symbol;
		$actual   = $symbol->getSymbol();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}	
	
	
	/* !__construct() */
	
	/**
	 * __construct() should return object if character and parameter are null
	 */
	public function testConstruct_returnsObject_ifSymbolAndParameterAreNull()
	{
		$token = new Symbol();
		
		$this->assertTrue($token instanceof Symbol);
		
		return;
	}
	
	/**
	 * __construct() should return object if symbol and parameter are not null
	 */
	public function testConstruct_returnsObject_ifSymbolAndParameterAreNotNull()
	{
		$symbol = '+';
		$parameter = '123';
		
		$token = new Symbol($symbol, $parameter);
		
		$this->assertTrue($token instanceof Symbol);
		$this->assertEquals($symbol, $token->getSymbol());
		$this->assertEquals($parameter, $token->getParameter());
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return string if symbol does not exist
	 */
	public function testToString_returnsString_SymbolDoesNotExist()
	{
		$token = new Symbol();
		
		$expected = '';
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	 
	/**
	 * __toString() should return string if symbol does exist
	 */
	public function testToString_returnsString_SymbolDoesExist()
	{
		$symbol = '+';
		
		$token = new Symbol($symbol);
		
		$expected = "\\$symbol ";
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * __toString() should return string if symbol and parameter do exist
	 */
	public function testToString_returnsString_SymbolAndParameterDoExist()
	{
		$symbol    = '\'';
		$parameter = '99';
		
		$token = new Symbol($symbol, $parameter);
		
		$expected = "\\'99 ";
		$actual   = (string) $token;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !createFromStream() */
	
	/**
	 * createFromStream() should throw an InvalidArgumentException if the current character in 
	 *     $characters is not a backslash ("\")
	 */
	public function testCreateFromStream_throwsInvalidArgumentException_ifCurrentCharacterIsNotBackslash()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$stream = new Stream\Text('abc');
		$symbol = Symbol::createFromStream($stream);
		
		return;
	}
	
	/**
	 * createFromStream() should throw an InvalidArgumentException if the next character in 
	 *     $characters is alpha-numeric
	 */
	public function testCreateFromStream_throwsInvalidArgumentException_ifNextCharacterIsAlphanumeric()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$stream = new Stream\Text('\\bc');
		$symbol = Symbol::createFromStream($stream);
		
		return;
	}
	
	/**
	 * createFromStream() should return false if $characters is empty
	 */
	public function testCreateFromStream_returnsFalse_ifCharactersIsEmpty()
	{
		$stream = new Stream\Text();
		
		$this->assertFalse(Symbol::createFromStream($stream));
		
		return;
	}
	
	/**
	 * createFromStream() should return false if the next character in $characters is empty
	 */
	public function testCreateFromStream_returnsFalse_ifNextCharacterIsEmpty()
	{
		$stream = new Stream\Text('\\');
		
		$this->assertFalse(Symbol::createFromStream($stream));
		
		return;
	}
	
	/**
	 * createFromStream() should return a Symbol if the next character is not alphanumeric
	 */
	public function testCreateFromStream_returnsSymbol_ifNextCharacterIsSymbol()
	{
		$stream = new Stream\Text('\\_');
		
		$symbol = Symbol::createFromStream($stream);
		
		$this->assertTrue($symbol instanceof Symbol);
		$this->assertEquals('_', $symbol->getSymbol());
		$this->assertNull($symbol->getParameter());
		// $this->assertEquals(1, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return a Symbol with parameters if the next character is
	 *     an apostrophe
	 */
	public function testCreateFromStream_returnsSymbol_ifNextCharacterIsApostrophe()
	{
		$stream = new Stream\Text("\\'ab");
		
		$symbol = Symbol::createFromStream($stream);
		
		$this->assertTrue($symbol instanceof Symbol);
		$this->assertEquals('\'', $symbol->getSymbol());
		$this->assertEquals('ab', $symbol->getParameter());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
}
