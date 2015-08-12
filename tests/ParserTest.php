<?php

namespace Jstewmc\Rtf;

/**
 * A test suite for the parser class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class ParserTest extends \PHPUnit_Framework_TestCase
{	
	/* !parse() */
	
	/**
	 * parse() should return null if $tokens is empty
	 */
	public function testParse_returnsNull_ifTokensIsEmpty()
	{
		$parser = new Parser();
		
		$this->assertNull($parser->parse([]));
		
		return;
	}
	
	/**
	 * parse() should ignore any text that occurs before the first group-open token
	 */
	public function testParse_parsesPretext()
	{
		$tokens = [
			new Token\Text('foo'),
			new Token\Group\Open(),
			new Token\Group\Close()	
		];
	
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		$this->assertEquals(new Element\Group(), $root);
		
		return;
	}
	
	/**
	 * parse() should parse a group-open and -close
	 */
	public function testParse_parsesGroups()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		$group = new Element\Group();
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should throw InvalidArgumentException if groups are mismatched
	 */
	public function test_parse_throwsInvalidArgumentException_ifGroupsMismatched()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$tokens = [
			new Token\Group\Open(),
			new Token\Group\Close(),
			new Token\Group\Close()
		];
		
		(new Parser())->parse($tokens);
		
		return;
	}
	
	/**
	 * parse() should parse nested groups
	 */
	public function testParse_parsesGroupsNested()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Group\Open(),
			new Token\Group\Open(),
			new Token\Group\Close(),
			new Token\Group\Close(),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		// create group and text elements
		$group1 = new Element\Group();
		$group2 = new Element\Group();
		$group3 = new Element\Group();
		
		// set parent-child and child-parent relationships
		$group2->setParent($group1);
		$group1->appendChild($group2);
		
		$group3->setParent($group2);
		$group2->appendChild($group3);
		
		$this->assertEquals($group1, $root);
		
		return;
	}
	
	/**
	 * parse() should parse a control word token
	 */
	public function testParse_parsesControlWords()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Control\Word('b'),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		// create group and text elements
		$group = new Element\Group();
		$word  = new Element\Control\Word\B();
		
		// set parent-child and child-parent relationships
		$word->setParent($group);
		$group->appendChild($word);
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should skip undefined control symbols
	 */
	public function testParse_parsesControlWordsUndefined()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Control\Word('foo'),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		$group = new Element\Group();
		
		$word = new Element\Control\Word\Word();
		$word->setWord('foo');
		
		$word->setParent($group);
		$group->appendChild($word);
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should parse a control symbol token
	 */
	public function testParse_parsesControlSymbols()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Control\Symbol('*'),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		// create group and text elements
		$group  = new Element\Group();
		$symbol = new Element\Control\Symbol\Asterisk();
		
		// set parent-child and child-parent relationships
		$symbol->setParent($group);
		$group->appendChild($symbol);
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should skip undefined control symbols
	 */
	public function testParse_parsesControlSymbolsUndefined()
	{
	 	$tokens = [
			new Token\Group\Open(),
			new Token\Control\Symbol('#'),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
	
		$group = new Element\Group();
		
		$symbol = new Element\Control\Symbol\Symbol();
		$symbol->setSymbol('#');
		
		$symbol->setParent($group);
		$group->appendChild($symbol);
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should parse a text token
	 */
	public function testParse_parsesText()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Text('foo'),
			new Token\Group\Close()
		];
		
		// parse the tokens
		$parser = new Parser();
		$root   = $parser->parse($tokens);
		
		// create group and text elements
		$group = new Element\Group();
		$text  = new ELement\Text('foo');
		
		// set parent-child and child-parent relationships
		$text->setParent($group);
		$group->appendChild($text);
		
		$this->assertEquals($group, $root);
		
		return;
	}
	
	/**
	 * parse() should parse a small document
	 */
	public function testParse_parsesDocumentSmall()
	{
		$tokens = [
			new Token\Group\Open(),
			new Token\Control\Word('rtf', 1),
			new Token\Control\Word('ansi'),
			new Token\Control\Word('deff', 0),
			new Token\Group\Open(),
			new Token\Control\Word('fonttbl'),
			new Token\Group\Open(),
			new Token\Control\Word('f', 0),
			new Token\Control\Word('fnil'),
			new Token\Control\Word('fcharset', 0),
			new Token\Text('Courier New;'),
			new Token\Group\Close(),
			new Token\Group\Close(),
			new Token\Group\Open(),
			new Token\Control\Symbol('*'),
			new Token\Control\Word('generator'),
			new Token\Text('Msftedit 5.41.15.1516;'),
			new Token\Group\Close(),
			new Token\Control\Word('viewkind', 4),
			new Token\Control\Word('uc', 1),
			new Token\Control\Word('pard'),
			new Token\Control\Word('lang', 1033),
			new Token\Control\Word('f', 0),
			new Token\Control\Word('fs', 20),
			new Token\Text('My dog is not like other dogs.'),
			new Token\Control\Word('par'),
			new Token\Text('He doesn\'t care to walk, '),
			new Token\Control\Word('par'),
			new Token\Text('He doesn\'t bark, he doesn\'t howl.'),
			new Token\Control\Word('par'),
			new Token\Text('He goes "Tick, tock. Tick, tock."'),
			new Token\Control\Word('par'),
			new Token\Group\Close()
		];
		
		$parser = new Parser();
		$root = $parser->parse($tokens);
		
		// create the expected elements in order...
		
		$groupA = new Element\Group();
		
		$a_1 = new Element\Control\Word\Word();
		$a_1->setWord('rtf');
		$a_1->setParameter(1); 
		$a_1->setParent($groupA);
		
		$a_2 = new Element\Control\Word\Word();
		$a_2->setWord('ansi');
		$a_2->setParent($groupA);
		
		$a_3 = new Element\Control\Word\Word();
		$a_3->setWord('deff');
		$a_3->setParameter(0); 
		$a_3->setParent($groupA);
		
		$groupB = new Element\Group();
		$groupB->setParent($groupA);
		
		$b_1 = new Element\Control\Word\Word();
		$b_1->setWord('fonttbl');
		$b_1->setParent($groupB);
		
		$groupC = new Element\Group();
		$groupC->setParent($groupB);
		
		$c_1 = new Element\Control\Word\Word();
		$c_1->setWord('f');
		$c_1->setParameter(0);
		$c_1->setParent($groupC);
		
		$c_2 = new Element\Control\Word\Word();
		$c_2->setWord('fnil');
		$c_2->setParent($groupC);
		
		$c_3 = new Element\Control\Word\Word();
		$c_3->setWord('fcharset');
		$c_3->setParameter(0);
		$c_3->setParent($groupC);
		
		$c_4 = new Element\Text('Courier New;');
		$c_4->setParent($groupC);
		
		$groupD = new Element\Group();
		$groupD->setParent($groupA);
		
		$d_1 = new Element\Control\Symbol\Asterisk();
		$d_1->setParent($groupD);
		
		$d_2 = new Element\Control\Word\Word();
		$d_2->setWord('generator');
		$d_2->setParent($groupD);
		
		$d_3 = new Element\Text('Msftedit 5.41.15.1516;');
		$d_3->setParent($groupD);
		
		// back to a
		
		$a_4 = new Element\Control\Word\Word();
		$a_4->setWord('viewkind');
		$a_4->setParameter(4);
		$a_4->setParent($groupA);
		
		$a_5 = new Element\Control\Word\Word();
		$a_5->setWord('uc');
		$a_5->setParameter(1);
		$a_5->setParent($groupA);
		
		$a_6 = new Element\Control\Word\Pard();
		$a_6->setParent($groupA);
		
		$a_7 = new Element\Control\Word\Word();
		$a_7->setWord('lang');
		$a_7->setParameter(1033);
		$a_7->setParent($groupA);
		
		$a_8 = new Element\Control\Word\Word();
		$a_8->setWord('f');
		$a_8->setParameter(0);
		$a_8->setParent($groupA);
		
		$a_9 = new Element\Control\Word\Word();
		$a_9->setWord('fs');
		$a_9->setParameter(20);
		$a_9->setParent($groupA);
		
		$a_10 = new Element\Text('My dog is not like other dogs.');
		$a_10->setParent($groupA);
		
		$a_11 = new Element\Control\Word\Par();
		$a_11->setParent($groupA);
		
		$a_12 = new Element\Text('He doesn\'t care to walk, ');
		$a_12->setParent($groupA);
		
		$a_13 = new Element\Control\Word\Par();
		$a_13->setParent($groupA);
		
		$a_14 = new Element\Text('He doesn\'t bark, he doesn\'t howl.');
		$a_14->setParent($groupA);
		
		$a_15 = new Element\Control\Word\Par();
		$a_15->setParent($groupA);
		
		$a_16 = new Element\Text('He goes "Tick, tock. Tick, tock."');
		$a_16->setParent($groupA);
		
		$a_17 = new Element\Control\Word\Par();
		$a_17->setParent($groupA);
		
		// now, set the relationships...
		
		$groupD
			->appendChild($d_1)
			->appendChild($d_2)
			->appendChild($d_3);
		
		$groupC
			->appendChild($c_1)
			->appendChild($c_2)
			->appendChild($c_3)
			->appendChild($c_4);
			
		$groupB
			->appendChild($b_1)
			->appendChild($groupC);
		
		$groupA
			->appendChild($a_1)
			->appendChild($a_2)
			->appendChild($a_3)
			->appendChild($groupB)
			->appendChild($groupD)
			->appendChild($a_4)
			->appendChild($a_5)
			->appendChild($a_6)
			->appendChild($a_7)
			->appendChild($a_8)
			->appendChild($a_9)
			->appendChild($a_10)
			->appendChild($a_11)
			->appendChild($a_12)
			->appendChild($a_13)
			->appendChild($a_14)
			->appendChild($a_15)
			->appendChild($a_16)
			->appendChild($a_17);
		
		// phew! 
		$this->assertEquals($groupA, $root);
		
		return;
	}
	
}
