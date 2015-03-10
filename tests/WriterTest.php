<?php

namespace Jstewmc\Rtf;

/**
 * An RTF writer
 *
 * An RTF writer writes the document to a string.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
	/* !write() */
	
	/**
	 * write() should return a string if elements do not exist
	 */
	public function testWrite_returnsString_ifElementsDoNotExist()
	{	
		$writer = new Writer();
		 
		$expected = '{}';
		$actual   = $writer->write(new Element\Group());
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if elements do exist
	 */
	public function testWrite_returnsString_ifElementsDoExist()
	{
		$group = (new Element\Group())
			->appendChild(new Element\Text('foo '))
			->appendChild((new Element\Group())
				->appendChild(new Element\Control\Word\B())
				->appendChild(new Element\Text('bar'))
				->appendChild(new Element\Control\Word\B(0))
			);
		
		$renderer = new Renderer();
		$root = $renderer->render($group);
		
		$writer = new Writer();
		
		$expected = '{foo {\b1 bar\b0 }}';
		$actual   = $writer->write($root);
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
