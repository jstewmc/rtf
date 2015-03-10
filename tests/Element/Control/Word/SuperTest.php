<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Super control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class SuperTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should superscript the characters if the parameter is not zero
	 */
	public function testRun_doesSuperscript_ifParameterIsNotZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Super();
		$element->setParameter('1');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsSuperscript());
		
		return;
	}
	
	/**
	 * run() should superscript the characters if the parameter is zero
	 */
	public function testRun_doesNotSuperscript_ifParameterIsZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Super();
		$element->setParameter('0');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsSuperscript());
		
		return;
	}
}
