<?php

namespace Jstewmc\Rtf\Element;

/**
 * A test suite for the Text class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class TextTest extends \PHPUnit_Framework_TestCase
{
	/* !Get/set methods */
	
	/**
	 * setText() and getText() should set and get the element's text, respectively
	 */
	public function testSetGetText()
	{
		$string = 'foo';
		
		$text = new Text();
		
		$text->setText($string);
		
		$expected = $string;
		$actual   = $text->getText();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}	
	
	
	/* !__construct() */
	
	/**
	 * __construct() should return text element if text is null
	 */
	public function testConstruct_returnsElement_ifTextIsNotString()
	{
		$text = new Text();
		
		$this->assertTrue($text instanceof Text);
		$this->assertNull($text->getText());
		
		return;
	}
	
	/**
	 * __construct() should return text element if text is string
	 */
	public function testConstruct_returnsElement_ifTextIsString()
	{
		$string = 'foo';
		
		$text = new Text($string);
		
		$this->assertTrue($text instanceof Text);
		$this->assertEquals($string, $text->getText());
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return string if text does not exist
	 */
	public function testToString_returnsString_ifTextDoesNotExist()
	{
		$text = new Text();
		
		$this->assertEquals('', (string) $text);
		
		return;
	}
	
	/**
	 * __toString() should return string if text does exist
	 */
	public function testToString_returnsString_ifTextDoesExist()
	{
		$string = 'foo';
		
		$text = new Text($string);
		
		$expected = $string;
		$actual   = (string) $text;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !format() */
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsHtml()
	{
		$text = new Text('foo & bar');
		
		$expected = 'foo &amp; bar';
		$actual   = $text->format('html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is rtf
	 */
	public function testFormat_returnsString_ifFormatIsRtf()
	{
		$text = new Text('foo \ bar');
		
		$expected = 'foo \\\\ bar';
		$actual   = $text->format('rtf');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is text
	 */
	public function testFormat_returnsString_ifFormatIsText()
	{
		$text = new Text('foo & bar');
		
		$expected = 'foo & bar';
		$actual   = $text->format('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
