<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Par control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class PlainTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should reset the character state
	 */
	public function testRun_incrementsParagraphIndex()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$old = $style->getCharacter()->getIsBold();
		
		$style->getCharacter()->setIsBold( ! $old);
		
		$element = new Plain();
		$element->setStyle($style);
		$element->run();
		
		$new = $style->getCharacter()->getIsBold();
		
		$this->assertEquals($old, $new);
		
		return;
	}
}
