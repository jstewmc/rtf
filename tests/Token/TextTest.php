<?php

use Jstewmc\Rtf\Token\Text;
use Jstewmc\Stream;

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
	
	
	/* !createFromStream() */
	
	/**
	 * createFromStream() should return false if $stream is empty
	 */
	public function testCreateFromStream_returnsFalse_ifCharactersIsEmpty()
	{
		$stream = new Stream\Text();
		
		return $this->assertFalse(Text::createFromStream($stream));
	}
	
	/**
	 * createFromStream() should return text token up to control word
	 */
	public function testCreateFromStream_returnText_ifCharactersHasControlWord()
	{
		$stream = new Stream\Text('foo \\bar');
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token up to control symbol
	 */
	public function testCreateFromStream_returnText_ifCharactersHasControlSymbol()
	{
		$stream = new Stream\Text('foo \\+');
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token up to group-open
	 */
	public function testCreateFromStream_returnText_ifCharactersHasGroupOpen()
	{
		$stream = new Stream\Text('foo {');
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token up to group-close
	 */
	public function testCreateFromStream_returnText_ifCharactersHasGroupClose()
	{
		$stream = new Stream\Text('foo }');
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo ', $token->getText());
		// $this->assertEquals(3, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token if $characters contains *unescaped*
	 *     line-feed 
	 */
	public function testCreateFromStream_returnText_ifCharactersHasLineFeedUnescaped()
	{
		$stream = new Stream\Text("foo\nbar");
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foobar', $token->getText());
		// $this->assertNull(key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token if $characters contains *escaped*
	 *     line-feed
	 */
	public function testCreateFromStream_returnText_ifCharactersHasLineFeedEscaped()
	{
		$stream = new Stream\Text("foo\\\nbar");
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo', $token->getText());
		// $this->assertEquals(2, key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token if $characters contains *unescaped*
	 *     carriage-return
	 */
	public function testCreateFromStream_returnText_ifCharactersHasCarriageReturnUnescaped()
	{
		$stream = new Stream\Text("foo\rbar");
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foobar', $token->getText());
		// $this->assertNull(key($characters));
		
		return;
	}
	
	/**
	 * createFromStream() should return text token if $characters contains *escaped*
	 *     carriage-return
	 */
	public function testCreateFromStream_returnText_ifCharactersHasCarriageReturnEscaped()
	{
		$characters = new Stream\Text("foo\\\rbar");
		
		$token = Text::createFromStream($stream);
		
		$this->assertTrue($token instanceof Text);
		$this->assertEquals('foo', $token->getText());
		// $this->assertEquals(2, key($characters));
		
		return;
	}
}
