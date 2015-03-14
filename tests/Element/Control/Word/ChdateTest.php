<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Chdate control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class ChdateTest extends \PHPUnit_Framework_TestCase
{
	/* !format() */
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsHtml()
	{
		$word = new Chdate();
		
		$expected = (new \DateTime())->format('m.d.Y');
		$actual   = $word->format('html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsText()
	{
		$word = new Chdate();
		
		$expected = (new \DateTime())->format('m.d.Y');
		$actual   = $word->format('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
