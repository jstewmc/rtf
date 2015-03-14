<?php

namespace Jstewmc\Rtf\State;

/**
 * A test suite for the State class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class StateTest extends \PHPUnit_Framework_TestCase
{
	/* !format() */
	
	/**
	 * format() should return a string
	 */
	public function testFormat()
	{
		return $this->assertEquals('', (new State())->format('foo'));
	}
	
	/* !reset() */
	
	/**
	 * reset() should reset the class variables to their default state
	 */
	public function testReset()
	{
		// hmmm, how do I test the method when the base class doesn't have properties?
	}
}
