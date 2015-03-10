<?php

namespace Jstewmc\Rtf;

/**
 * A test suite for the Style class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class StyleTest extends \PHPUnit_Framework_TestCase
{
	/* !getCharacter()/setCharacter() */
	
	/**
	 * getCharacter() and setCharacter() should get and set the character, respectively
	 */
	public function testGetSetCharacter()
	{
		$character = new State\Character();
		
		$style = new Style();
		$style->setCharacter($character);
		
		$expected = $character;
		$actual   = $style->getCharacter();
		
		$this->assertSame($expected, $actual);
		
		return;
	}
	 
	/* !getDocument()/setDocument() */	
	
	/**
	 * getDocument() and setDocument() should get and set the document, respectively
	 */
	public function testGetSetDocument()
	{
		$document = new State\Document();
		
		$style = new Style();
		$style->setDocument($document);
		
		$expected = $document;
		$actual   = $style->getDocument();
		
		$this->assertSame($expected, $actual);
		
		return;
	}
	
	/* !getParagraph()/setParagraph() */
	
	/**
	 * getParagraph() and setParagraph() should get and set the paragraph, respectively
	 */
	public function testGetSetParagraph()
	{
		$paragraph = new State\Paragraph();
		
		$style = new Style();
		$style->setParagraph($paragraph);
		
		$expected = $paragraph;
		$actual   = $style->getParagraph();
		
		$this->assertSame($expected, $actual);
		
		return;
	}
	
	
	/* !getSection()/setSection() */
	
	/** 
	 * getSection() and setSection() should get and set the section, respectively
	 */
	public function testGetSetSection()
	{
		$section = new State\Section();
		
		$style = new Style();
		$style->setSection($section);
		
		$expected = $section;
		$actual   = $style->getSection();
		
		$this->assertSame($expected, $actual);
		
		return;	
	}
	
	
	/* !__construct() */
	
	/**
	 * __construct() should instantiate the style's document, section, paragraph, and
	 *     character states
	 */
	public function testConstruct()
	{
		$style = new Style();
		
		$this->assertTrue($style->getDocument() instanceof State\Document);
		$this->assertTrue($style->getSection() instanceof State\Section);
		$this->assertTrue($style->getParagraph() instanceof State\Paragraph);
		$this->assertTrue($style->getCharacter() instanceof State\Character);
		
		return;
	}
	 
	 
	/* !__clone() */
	
	/**
	 * __clone() should perform a deep copy of a style's states
	 */
	public function testClone()
	{
		$style1 = new Style();
		
		$style2 = clone $style1;
		
		$this->assertTrue($style2->getDocument() instanceof State\Document);
		$this->assertTrue($style2->getSection() instanceof State\Section);
		$this->assertTrue($style2->getParagraph() instanceof State\Paragraph);
		$this->assertTrue($style2->getCharacter() instanceof State\Character);
		
		$this->assertNotSame($style1->getDocument(), $style2->getDocument());
		$this->assertNotSame($style1->getSection(), $style2->getSection());
		$this->assertNotSame($style1->getParagraph(), $style2->getParagraph());
		$this->assertNotSame($style1->getCharacter(), $style2->getCharacter());
		
		return;
	}
	
	
	/* !merge() */
	
	/**
	 * merge() should merge styles if the states are the same
	 */
	public function testMerge_doesMergeStyles_ifStatesAreSame()
	{
		$style1 = new Style();
		$style2 = new Style();
		
		$style2->merge($style1);
		
		$this->assertSame($style1->getDocument(), $style2->getDocument());
		$this->assertSame($style1->getSection(), $style2->getSection());
		$this->assertSame($style1->getParagraph(), $style2->getParagraph());
		$this->assertSame($style1->getCharacter(), $style2->getCharacter());
		
		return;
	}
	 
	/**
	 * merge() should not merge style if the states are different
	 */
	public function testMerge_doesNotMergeStyles_ifStatesAreDifferent()
	{
		$style1 = new Style();
		
		$style2 = new Style();
		
		// $style2->getDocument()->setSomething();
		$style2->getSection()->setIndex(999);
		$style2->getParagraph()->setIndex(999);
		$style2->getCharacter()->setIsBold(true);
		
		$style2->merge($style1);
		
		// $this->assertNotSame($style1->getDocument(), $style2->getDocument());
		$this->assertNotSame($style1->getSection(), $style2->getSection());
		$this->assertNotSame($style1->getParagraph(), $style2->getParagraph());
		$this->assertNotSame($style1->getCharacter(), $style2->getCharacter());
		
		return;
	}
}
