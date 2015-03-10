<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the V control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class VTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should make characters visible if parameter is omitted
	 */
	public function testRun_doesShow_ifParameterIsOmitted()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new V();
		$element->setStyle($style);
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());
		
		return;
	}
	
	/**
	 * run() should make characters visible if parameter is not zero
	 */
	public function testRun_doesShow_ifParameterIsNotZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new V();
		$element->setParameter('1');
		$element->setStyle($style);
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());
		
		return;
	}
	
	/**
	 * run() should make characters visible if parameter is not zero
	 */
	public function testRun_doesNotShow_ifParameterIsZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new V();
		$element->setParameter('0');
		$element->setStyle($style);
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsVisible());
		
		return;
	}
}
