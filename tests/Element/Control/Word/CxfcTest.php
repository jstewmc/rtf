<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\Group;
use Jstewmc\Rtf\Element\Text;
use Jstewmc\Rtf\Element\Element;
use Jstewmc\Rtf\Style;

/**
 * Tests for the "\cxfc" control word
 */
class CxfcTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should do nothing if a next text element does not exist
	 */
	public function testRun_doesNothing_ifNextTextElementDoesNotExist()
	{
		$word = new Cxfc();
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($word)->render();
		
		// hmm, I don't know what to assert here
		// I guess we just want to be sure nothing bad happens?
		
		return;
	}
	
	/**
	 * run() should upper-case the next text element's first character if it does exist
	 */
	public function testRun_upperCasesFirstCharacter_ifNextTextElementDoesExist()
	{
		$word = new Cxfc();
		$text = (new Text())->setText('foo');  // note the lower-case
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($word)
			->appendChild($text)
			->render();
		
		$this->assertEquals('Foo', $text->getText());
		
		return;
	}
}
