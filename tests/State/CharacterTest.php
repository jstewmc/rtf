<?php

namespace Jstewmc\Rtf\State;

/**
 * A test suite for the Character state class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class CharacterTest extends \PHPUnit_Framework_TestCase
{
	/* !Providers */
	
	public function notAStringProvider()
	{
		return [
			[null],
			[false],
			[1],
			[1.0],
			['foo'],
			[[]],
			[new \StdClass()]
		];
	}
	
	
	/* !getIsBold() / setIsBold() */
	
	/**
	 * getIsBold() and setIsBold() should get and set the bold flag, respectively
	 */
	public function testGetSetIsBold()
	{
		$character = new Character();
		$character->setIsBold(true);
		
		$this->assertTrue($character->getIsBold());
		
		return;
	}
	
	
	/* !getIsItalic() / setIsItalic() */
	
	/**
	 * getIsItalic() and setIsItalic() should get and set the italic flag, respectively
	 */
	public function testGetSetIsItalic()
	{
		$character = new Character();
		$character->setIsItalic(true);
		
		$this->assertTrue($character->getIsItalic());
		
		return;
	}
	
	
	/* !getIsSubscript() / setIsSubscript() */
	
	/**
	 * getIsSubscript() and setIsSubscript() should get and set the subscript flag, respectively
	 */
	public function testGetSetIsSubscript()
	{
		$character = new Character();
		$character->setIsSubscript(true);
		
		$this->assertTrue($character->getIsSubscript());
		
		return;
	} 
	
	
	/* !getIsSuperscript() / setIsSuperscript() */
	
	/**
	 * getIsSuperscript() and setIsSuperscript() should get and set the superscript flag, respectively
	 */
	public function testGetSetIsSuperscript()
	{
		$character = new Character();
		$character->setIsSuperscript(true);
		
		$this->assertTrue($character->getIsSuperscript());
		
		return;
	}
	
	
	/* !getIsStrikethrough() / setIsStrikethrough() */
	
	/** 
	 * getIsStrikethrough() and setIsStrikethrough() should get and set the strikethrough flag, respectively
	 */
	public function testGetSetStrikethrough()
	{
		$character = new Character();
		$character->setIsStrikethrough(true);
		
		$this->assertTrue($character->getIsStrikethrough());
		
		return;
	}
	
	
	/* !getIsUnderline() / setIsUnderline() */
	 
	/**
	 * getIsUnderline() and setIsUnderline() should get and set the underline flag, respectively
	 */
	public function testGetSetUnderline()
	{
		$character = new Character();
		$character->setIsUnderline(true);
		
		$this->assertTrue($character->getIsUnderline());
		
		return;
	}
	
	
	/* !getIsVisible() / setIsVisible() */
	
	/**
	 * getIsVisible() and setIsVisible() should get and set the visible flag, respectively
	 */
	public function testGetSetIsVisible()
	{
		$character = new Character();
		$character->setIsVisible(false);
		
		$this->assertFalse($character->getIsVisible());
		
		return;
	}
	
	
	/* !format() */
	
	/**
	 * format() should throw an InvalidArgumentException if $format is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testFormat_throwsInvalidArgumentException_ifFormatIsNotAString($format)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$state = new Character();
		$state->format($state);
		
		return;
	}
	
	/**
	 * format() should throw an InvalidArgumentException if $format is not valid
	 */
	public function testFormat_throwsInvalidArgumentException_ifFormatIsNotValid()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$state = new Character();
		$state->format('foo');
		
		return;
	}
	
	/**
	 * format() should return a string if $format is valid
	 */
	public function testFormat_returnsString_ifFormatIsValid()
	{
		$state = new Character();
		
		$state->setIsBold(true);
		$state->setIsItalic(true);
		
		$expected = 'font-weight: bold; font-style: italic;';
		$actual   = $state->format('css');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
