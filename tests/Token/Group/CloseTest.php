<?php

use Jstewmc\Rtf\Token\Group\Close;

/**
 * A test suite for the Token\Group\Close class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
 
class CloseTest extends PHPUnit_Framework_Testcase
{
	/* !__toString() */
	
	/**
	 * __toString() should return the close-bracket character ("}")
	 */
	public function testToString_returnsString()
	{
		$token = new Close();
		
		$this->assertEquals('}', (string) $token);
		
		return;
	}
}
