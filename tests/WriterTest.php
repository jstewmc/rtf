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
	/* !Data providers */
	
	public function notAStringProvider()
	{
		return [
			[null],
			[false],
			[1],
			[1.0],
			// ['foo'],
			[[]],
			[new \StdClass()]
		];
	}
	
	/* !write() */
	
	/**
	 * write() should throw an InvalidArgumentException if $format is not a string
	 * 
	 * @dataProvider  notAStringProvider
	 */
	public function testWrite_throwsInvalidArgumentException_ifFormatIsNotAString($format)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$writer = new Writer();
		$writer->write(new Element\Group(), $format);
		
		return;
	}
	
	/**
	 * write() should throw an InvalidArgumentException if $format is not 'html', 'rtf', or
	 * 'text'
	 */
	public function testWrite_throwsInvalidArgumentException_ifFormatIsNotValid()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$writer = new Writer();
		$writer->write(new Element\Group(), 'foo');
		
		return;
	}
	
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
		
		$expected = '{foo {\b bar\b0 }}';
		$actual   = $writer->write($root);
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if format is html
	 */
	public function testWrite_returnsString_ifFormatIsHtml()
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
		
		$expected = '<section style=""><p style=""><span style="">foo </span>'
			. '<span style="font-weight: bold;">bar</span></p></section>';
		$actual = $writer->write($root, 'html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if format is rtf
	 */
	public function testWrite_returnsString_ifFormatIsRtf()
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
		
		$expected = '{foo {\b bar\b0 }}';
		$actual   = $writer->write($root, 'rtf');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if format is text
	 */
	public function testWrite_returnsString_ifFormatIsText()
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
		
		$expected = 'foo bar';
		$actual   = $writer->write($root, 'text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
