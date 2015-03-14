<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * A test suite for the hyphen control symbol
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
 
class HyphenTest extends \PHPUnit_Framework_TestCase
{
	/* !format() */
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsHtml()
	{
		$symbol = new Hyphen();
		
		$expected = '-';
		$actual   = $symbol->format('html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsText()
	{
		$symbol = new Hyphen();
		
		$expected = '-';
		$actual   = $symbol->format('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
