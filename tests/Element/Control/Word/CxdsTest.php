<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\Group;
use Jstewmc\Rtf\Element\Text;
use Jstewmc\Rtf\Element\Element;
use Jstewmc\Rtf\Style;

/**
 * Tests for the Cxp control word
 */
class CxdsTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should do nothing if previous text element does not exist
	 */
	public function testRun_doesNothing_ifPreviousTextElementDoesNotExist()
	{
		$word = new Cxds();
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($word)->render();
		
		// hmm, I don't know what to assert here
		// I guess we just want to be sure nothing bad happens?
		
		return;
	}
	
	/**
	 * run() should do nothing if previous text element does not end with space
	 */
	public function testRun_doesNothing_ifPreviousTextElementDoesNotEndWithSpace()
	{
		$word = new Cxds();
		$text = (new Text())->setText('foo');
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($text)
			->appendChild($word)
			->render();
		
		$this->assertEquals('foo', $text->getText());
		
		return;
	}
	
	/**
	 * run() should delete space if previous text element ends with space
	 */
	public function testRun_deletesSpace_ifPreviousTextElementDoesEndWithSpace()
	{
		$word = new Cxds();
		$text = (new Text())->setText('foo ');  // note the space
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($text)
			->appendChild($word)
			->render();
		
		$this->assertEquals('foo', $text->getText());
		
		return;
	}
}
