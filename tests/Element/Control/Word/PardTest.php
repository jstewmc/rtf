<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Pard control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class PardTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should reset the paragraph state
	 */
	public function testRun_resetsParagraphState()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$old = $style->getParagraph()->getIndex();
		
		$style->getParagraph()->setIndex(999);
		
		$element = new Pard();
		$element->setStyle($style);
		$element->run();
		
		$new = $style->getParagraph()->getIndex();
		
		$this->assertEquals($old, $new);
		
		return;
	}
}
