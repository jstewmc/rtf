<?php
	
namespace Jstewmc\Rtf\State;

/**
 * A test suite for the Section class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class ParagraphTest extends \PHPUnit_Framework_TestCase
{
	/* !getIndex() / setIndex() */
	
	/**
	 * getIndex() and setIndex() should get and set the index, respectively
	 */
	public function testGetSetIndex()
	{
		$index = 999;
		
		$paragraph = new Paragraph();
		$paragraph->setIndex($index);
		
		$expected = $index;
		$actual   = $paragraph->getIndex();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
