<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Strike control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class StrikeTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should strikethrough the character is parameter is not zero
	 */
	public function testRun_doesStrikethrough_ifParameterIsNotZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Strike();
		$element->setParameter('1');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsStrikethrough());
		
		return;
	}
	
	/**
	 * run() should update the element's style
	 */
	public function testRun_doesNotStrikethrough_ifParameterIsZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Strike();
		$element->setParameter('0');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsStrikethrough());
		
		return;
	}
}
