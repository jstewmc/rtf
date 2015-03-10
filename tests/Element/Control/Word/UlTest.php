<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Ul control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class UlTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should underline the characters if the parameter is omitted
	 */
	public function testRun_doesUnderline_ifParameterIsOmitted()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Ul();
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());
		
		return;
	}
	
	/**
	 * run() should underline the characters if the parameter is not zero
	 */
	public function testRun_doesUnderline_ifParameterIsNotZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Ul();
		$element->setParameter('1');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
		
		$element->run();
		
		$this->assertTrue($element->getStyle()->getCharacter()->getIsUnderline());
		
		return;
	}
	
	/**
	 * run() should update the element's style
	 */
	public function testRun_doesNotUnderline_ifParameterIsZero()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$element = new Ul();
		$element->setParameter('0');
		$element->setStyle($style);
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
		
		$element->run();
		
		$this->assertFalse($element->getStyle()->getCharacter()->getIsUnderline());
		
		return;
	}
}
