<?php

use Jstewmc\Rtf\Token\Text;

/**
 * A test suite for the Token\Text class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class TextTest extends PHPUnit_Framework_Testcase
{		
	/* !Get/set methods */
	
	/**
	 * setText() and getText() should set and get the character
	 */
	public function testSetCharacterAndGetText()
	{
		$text = 'foo bar baz';
		
		$token = new Text();
		$token->setText($text);
		
		$expected = $text;
		$actual   = $token->getText();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !__construct() */
	
	/**
	 * __construct() should return object is $text is null
	 */
	public function testConstruct_returnsToken_ifTextIsNull()
	{
		$token = new Text();
		
		$this->assertTrue($token instanceof Text);
		
		return;	
	}
	
	/**
	 * __construct() should return object if $character is string
	 */
	public function testConstruct_returnsToken_ifTextIsString()
	{
		$text = 'foo bar baz';
		
		$token = new Text($text);
		
		$expected = $text;
		$actual   = $token->getText();
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !createFromSource() */
	
	/**
	 * createFromSource() should return false if $characters is empty
	 */
	public function testCreateFromSource_returnsFalse_ifCharactersIsEmpty()
	{
		$characters = [];
		
		return $this->assertFalse(Text::createFromSource($characters));
	}
	
	/**
	 * createFromSource() should return text token up to control word
	 */
	public function testCreateFromSource_returnText_ifCharactersHasControlWord()
	{
		$characters = ['f', 'o', 'o', ' ', '\\', 'b', 'a', 'r'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		$this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token up to control symbol
	 */
	public function testCreateFromSource_returnText_ifCharactersHasControlSymbol()
	{
		$characters = ['f', 'o', 'o', ' ', '\\', '+'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		$this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token up to group-open
	 */
	public function testCreateFromSource_returnText_ifCharactersHasGroupOpen()
	{
		$characters = ['f', 'o', 'o', ' ', '{'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		$this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token up to group-close
	 */
	public function testCreateFromSource_returnText_ifCharactersHasGroupClose()
	{
		$characters = ['f', 'o', 'o', ' ', '}'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		$this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token if $characters contains *unescaped*
	 *     line-feed 
	 */
	public function testCreateFromSource_returnText_ifCharactersHasLineFeedUnescaped()
	{
		$characters = ['f', 'o', 'o', "\n", 'b', 'a', 'r'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foobar', $token->getText());
		$this->assertNull(key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token if $characters contains *escaped*
	 *     line-feed
	 */
	public function testCreateFromSource_returnText_ifCharactersHasLineFeedEscaped()
	{
		$characters = ['f', 'o', 'o', '\\', "\n", 'b', 'a', 'r'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo', $token->getText());
		$this->assertEquals(2, key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token if $characters contains *unescaped*
	 *     carriage-return
	 */
	public function testCreateFromSource_returnText_ifCharactersHasCarriageReturnUnescaped()
	{
		$characters = ['f', 'o', 'o', "\r", 'b', 'a', 'r'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foobar', $token->getText());
		$this->assertNull(key($characters));
		
		return;
	}
	
	/**
	 * createFromSource() should return text token if $characters contains *escaped*
	 *     carriage-return
	 */
	public function testCreateFromSource_returnText_ifCharactersHasCarriageReturnEscaped()
	{
		$characters = ['f', 'o', 'o', '\\', "\r", 'b', 'a', 'r'];
		
		$token = Text::createFromSource($characters);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo', $token->getText());
		$this->assertEquals(2, key($characters));
		
		return;
	}
}
