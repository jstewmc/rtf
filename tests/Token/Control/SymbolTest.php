<?php

use Jstewmc\Rtf\Token\Control\Symbol;

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
	
	
	/* !createFromSource() */
	
	/**
	 * createFromSource() should throw an InvalidArgumentException if the current character in 
	 *     $characters is not a backslash ("\")
	 */
	public function testCreateFromSource_throwsInvalidArgumentException_ifCurrentCharacterIsNotBackslash()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$characters = ['a', 'b', 'c'];
		$symbol = Symbol::createFromSource($characters);
		
		return;
	}
	
	/**
	 * createFromSource() should throw an InvalidArgumentException if the next character in 
	 *     $characters is alpha-numeric
	 */
	public function testCreateFromSource_throwsInvalidArgumentException_ifNextCharacterIsAlphanumeric()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$characters = ['\\', 'b', 'c'];
		$symbol = Symbol::createFromSource($characters);
		
		return;
	}
	
	/**
	 * createFromSource() should return false if $characters is empty
	 */
	public function testCreateFromSource_returnsFalse_ifCharactersIsEmpty()
	{
		$characters = [];
		
		$this->assertFalse(Symbol::createFromSource($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return false if the next character in $characters is empty
	 */
	public function testCreateFromSource_returnsFalse_ifNextCharacterIsEmpty()
	{
		$characters = ['\\'];
		
		$this->assertFalse(Symbol::createFromSource($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a Symbol if the next character is not alphanumeric
	 */
	public function testCreateFromSource_returnsSymbol_ifNextCharacterIsSymbol()
	{
		$characters = ['\\', '_'];
		
		$symbol = Symbol::createFromSource($characters);
		
		$this->assertTrue($symbol instanceof Symbol);
		$this->assertEquals('_', $symbol->getSymbol());
		$this->assertNull($symbol->getParameter());
		$this->assertEquals(1, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return a Symbol with parameters if the next character is
	 *     an apostrophe
	 */
	public function testCreateFromSource_returnsSymbol_ifNextCharacterIsApostrophe()
	{
		$characters = ['\\', '\'', 'a', 'b'];
		
		$symbol = Symbol::createFromSource($characters);
		
		$this->assertTrue($symbol instanceof Symbol);
		$this->assertEquals('\'', $symbol->getSymbol());
		$this->assertEquals('ab', $symbol->getParameter());
		$this->assertEquals(3, key($characters));
		
		return;
	}
}
