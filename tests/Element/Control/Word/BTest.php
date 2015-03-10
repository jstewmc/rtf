<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the bold control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class BTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should update the element's style
	 */
	public function testRun_doesBold_ifParameterIsNotZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new B();
		$element->setParameter('1');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsBold());
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsBold());
		
		return;
	}
	
	/**
	 * run() should update the element's style
	 */
	public function testRun_doesNotBold_ifParameterIsZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new B();
		$element->setParameter('0');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsBold());
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsBold());
		
		return;
	}
}
