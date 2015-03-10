<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Ulnone control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class UlnoneTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should not underline (regardless of parameter's value)
	 */
	public function testRun_doesNotUnderline()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$style->getCharacter()->setIsUnderline(true);
		
		$element = new Ulnone();
		$element->setStyle($style);
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
		
		return;
	}
}
