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

class ParTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should increment the paragraph index
	 */
	public function testRun_incrementsParagraphIndex()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$old = $style->getParagraph()->getIndex();
		
		$element = new Par();
		$element->setStyle($style);
		$element->run();
		
		$new = $style->getParagraph()->getIndex();
		
		$this->assertGreaterThan($old, $new);
		
		return;
	}
}
