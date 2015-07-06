<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\Group;
use Jstewmc\Rtf\Element\Text;
use Jstewmc\Rtf\Element\Element;
use Jstewmc\Rtf\Style;

/**
 * Tests for the "\cxfl" control word
 */
class CxflTest extends \PHPUnit_Framework_TestCase
{
	/* !run() */
	
	/**
	 * run() should do nothing if a next text element does not exist
	 */
	public function testRun_doesNothing_ifNextTextElementDoesNotExist()
	{
		$word = new Cxfl();
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($word)->render();
		
		// hmm, I don't know what to assert here
		// I guess we just want to be sure nothing bad happens?
		
		return;
	}
	
	/**
	 * run() should lower-case the next text element's first character if it does exist
	 */
	public function testRun_lowerCasesFirstCharacter_ifNextTextElementDoesExist()
	{
		$word = new Cxfl();
		$text = (new Text())->setText('FOO');  // note the upper-case
		
		$parent = (new Group())
			->setStyle(new Style())
			->appendChild($word)
			->appendChild($text)
			->render();
		
		$this->assertEquals('fOO', $text->getText());
		
		return;
	}
}
