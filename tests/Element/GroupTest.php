<?php

namespace Jstewmc\Rtf\Element;	

/**
 * A test suite for the Group class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class GroupTest extends \PHPUNit_Framework_TestCase
{
	/* !Provider */
	
	public function notAnIntegerProvider()
	{
		return [
			[null],
			[true],
			// [1],
			[1.0],
			['foo'], 
			[[]],
			[new \StdClass()]
		];
	}
	
	public function neitherAnIntegerNorNullProvider()
	{
		return [
			// [null],
			[true],
			// [1],
			[1.0],
			['foo'], 
			[[]],
			[new \StdClass()]
		];
	}
	
	public function notAStringProvider()
	{
		return [
			[null],
			[false],
			[1.0],
			[1],
			// ['foo'],
			[[]],
			[new \StdClass()]
		];
	}
	
	
	/* !Get/set methods */
	
	/**
	 * setChildren() and getChildren() should return the group's children
	 */
	public function testSetAndGetChildren()
	{
		$children = [new Element(), new Element()];
		
		$group = new Group();
		$group->setChildren($children);
		
		$expected = $children;
		$actual   = $group->getChildren();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * setIsRendered() and getIsRendered() should return the is rendered flag
	 */
	public function testSetAndGetIsRendered()
	{
		$group = new Group();
		
		$group->setIsRendered(true);
		
		$this->assertTrue($group->getIsRendered());
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return a string if children do not exist
	 */
	public function testToString_returnsString_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertEquals('{}', (string) $group);
		
		return;
	}
	 
	/**
	 * __toString() should return a string if children do exist
	 */
	public function testToString_returnsString_ifChildrenDoExist()
	{
		$group = new Group();
		
		$group
			->appendChild(new Control\Word\B())
			->appendChild(new Text('foo'))
			->appendChild(new Control\Word\B(0));
		
		$expected = '{\b foo\b0 }';
		$actual   = (string) $group;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}

	
	/* !appendChild() */
	
	/**
	 * appendChild() should append the element if zero children exist
	 */
	public function testAppendChild_appendsChild_ifZeroChildrenExist()
	{
		$child = new Element();
		
		$group = new Group();
		$group->appendChild($child);
	
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 1);
		$this->assertSame($child, $group->getChildren()[0]);
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * appendChild() should append the element to the end if many children exist
	 */
	public function testAppendChild_appendsChild_ifManyChildrenExist()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$child = new Element();
		
		$group->appendChild($child);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 4);
		$this->assertSame($child, end($group->getChildren()));
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * appendChild() should not render the group if it's not rendered
	 */
	public function testAppendChild_doesNotRender_ifGroupIsNotRendered()
	{
		$group = new Group();
		
		$this->assertFalse($group->getIsRendered());
		
		$group->appendChild(new Element());
		
		$this->assertFalse($group->getIsRendered());
		
		return;	
	}
	
	/**
	 * appendChild() should render the group if it's rendered
	 */
	public function testAppendChild_doesRender_ifGroupIsRendered()
	{
		$group = new Group();
		$group->setStyle(new \Jstewmc\Rtf\Style());
		$group->setIsRendered(true);
	
		$this->assertTrue($group->getIsRendered());
		
		$group->appendChild(new Element());
		
		$this->assertTrue($group->getIsRendered());
		
		return;	
	}
	
	
	/* !format() */
	
	/**
	 * format() should return string if format is html
	 */
	public function testFormat_returnsString_ifFormatIsHtml()
	{
		$group = new Group();
		
		$group
			->appendChild(new Control\Word\B())
			->appendChild(new Text('foo'))
			->appendChild(new Control\Word\B(0));
			
		$group->setStyle(new \Jstewmc\Rtf\Style());
		
		$group->render();
			
		$expected = '<section style=""><p style=""><span style="font-weight: bold;">foo';
		$actual   = $group->format('html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is rtf
	 */
	public function testFormat_returnsString_ifFormatIsRtf()
	{
		$group = new Group();
		
		$group
			->appendChild(new Control\Word\B())
			->appendChild(new Text('foo'))
			->appendChild(new Control\Word\B(0));
			
		$expected = '{\b foo\b0 }';
		$actual   = $group->format('rtf');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return string if format is text
	 */
	public function testFormat_returnsString_ifFormatIsText()
	{
		$group = new Group();
		
		$group
			->appendChild(new Control\Word\B())
			->appendChild(new Text('foo'))
			->appendChild(new Control\Word\B(0));
			
		$expected = 'foo';
		$actual   = $group->format('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * format() should return (empty) string if group is destination
	 */
	public function testFormat_returnsString_ifGroupIsDestination()
	{
		$group = new Group();
		
		$group
			->appendChild(new Control\Symbol\Asterisk())
			->appendChild(new Control\Word\Word('foo'))
			->appendChild(new Text('bar'));
			
		$expected = '';
		$actual   = $group->format('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !getChild() */
	
	/**
	 * getChild() should throw an InvalidArgumentException if index is not a integer
	 *
	 * @dataProvider  notAnIntegerProvider()
	 */
	public function testGetChild_throwsInvalidArgumentException_ifIndexIsNotAnInteger($index)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->getChild($index);
		
		return;
	}
	
	/**
	 * getChild() should throw an OutOfBoundsException if index is invalid
	 */
	public function testGetChild_throwsOutOfBoundsException_ifIndexIsNotValid()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->getChild(999);
		
		return;
	}
	
	/**
	 * getChild() should return element if index is valid
	 */
	public function testGetChild_returnsElement_ifIndexIsValid()
	{
		$child = new Element();
		
		$group = new Group();
		$group->appendChild($child);
		
		$expected = $child;
		$actual   = $group->getChild(0);
		
		$this->assertSame($expected, $actual);
	
		return;
	}
	
	
	/* !getControlWords() */
	
	/**
	 * getControlWords() should throw InvalidArgumentException if $word is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testGetControlWords_throwsInvalidArgumentException_ifWordIsNotAString($word)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->getControlWords($word);
		
		return;
	}
	
	/**
	 * getControlWords() should throw InvalidArgumentException if $parameter is not null,
	 *     false, or integer
	 */
	public function testGetControlWords_throwsInvalidArgumentException_ifParameterIsInvalid()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->getControlWords('foo', []);
		
		return;
	}
	
	/**
	 * getControlWords() should return array if children do not exist
	 */
	public function testGetControlWords_returnsArray_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$expected = [];
		$actual   = $group->getControlWords('foo');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * getControlWords() should return array if child does not exist
	 */
	public function testGetControlWords_returnsArray_ifChildDoesNotExist()
	{
		$group = new Group();
		
		$group->appendChild(new Text('foo'));
		
		$expected = [];
		$actual   = $group->getControlWords('bar');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * getControlWords() should return array if child does exist
	 */
	public function testGetControlWords_returnsArray_ifChildDoesExist()
	{
		$one = new Control\Word\B();
		$two = new Control\Word\B(0);
		
		$group = new Group();
		
		$group->appendChild($one)->appendChild($two);
		
		$expected = [$one, $two];
		$actual   = $group->getControlWords('b');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/**
	 * getControlWords() should return array if children are groups
	 */
	public function testGetControlWords_returnsArray_ifChildIsGroup()
	{
		$one = new Control\Word\B();
		$two = new Control\Word\B();
		
		$group = new Group();
		
		$group
			->appendChild($one)
			->appendChild((new Group())
				->appendChild($two)
			);
		
		$expected = [$one, $two];
		$actual   = $group->getControlWords('b');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !getControlSymbols() */
	
	/**
	 * getControlSymbols() should throw InvalidArgumentException if $symbol is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testGetControlSymbols_throwsInvalidArgumentException_ifWordIsNotAString($symbol)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->getControlSymbols($symbol);
		
		return;
	}
	
	/**
	 * getControlSymbols() should throw InvalidArgumentException if $parameter is not null,
	 *     false, or integer
	 */
	public function testGetControlSymbols_throwsInvalidArgumentException_ifParameterIsInvalid()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->getControlSymbols('+', []);
		
		return;
	}
	
	/**
	 * getControlSymbols() should return array if children do not exist
	 */
	public function testGetControlSymbols_returnsArray_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$expected = [];
		$actual   = $group->getControlSymbols('+');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * getControlSymbols() should return array if child does not exist
	 */
	public function testGetControlSymbols_returnsArray_ifChildDoesNotExist()
	{
		$group = new Group();
		
		$group->appendChild(new Text('foo'));
		
		$expected = [];
		$actual   = $group->getControlSymbols('+');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * getControlSymbols() should return array if child does exist
	 */
	public function testGetControlSymbols_returnsArray_ifChildDoesExist()
	{
		$one = new Control\Symbol\Tilde();
		$two = new Control\Symbol\Tilde();
		
		$group = new Group();
		
		$group->appendChild($one)->appendChild($two);
		
		$expected = [$one, $two];
		$actual   = $group->getControlSymbols('~');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/**
	 * getControlSymbols() should return array if children are groups
	 */
	public function testGetControlSymbols_returnsArray_ifChildIsGroup()
	{
		$one = new Control\Symbol\Tilde('~');
		$two = new Control\Symbol\Tilde('~');
		
		$group = new Group();
		
		$group
			->appendChild($one)
			->appendChild((new Group())
				->appendChild($two)
			);
		
		$expected = [$one, $two];
		$actual   = $group->getControlSymbols('~');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !getChildIndex() */
	
	/**
	 * getChildIndex() should return false if children do not exist
	 */
	public function testGetChildIndex_returnsFalse_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertFalse($group->getChildIndex(new Text('foo')));
		
		return;
	}
	
	/**
	 * getChildIndex() should return false if child does not exist
	 */
	public function testGetChildIndex_returnsFalse_ifChildDoesNotExist()
	{
		$group = new Group();
		
		$foo = new Text('foo');
		$bar = new Text('bar');
		
		$group->appendChild($foo);
		
		$this->assertFalse($group->getChildIndex($bar));
		
		return;
	}
	
	/**
	 * getChildIndex() should return integer if child does exist
	 */
	public function testGetChildIndex_returnsInteger_ifChildDoesExist()
	{
		$group = new Group();
		
		$foo = new Text('foo');
		$bar = new Text('bar');
		
		$group->appendChild($foo)->appendChild($bar);
		
		$expected = 1;
		$actual   = $group->getChildIndex($bar);
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !getFirstChild() */
	
	/**
	 * getFirstChild() should return null if children do not exist
	 */
	public function testGetFirstChild_returnsNull_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertNull($group->getFirstChild());
		
		return;
	}
	
	/**
	 * getFirstChild() should return element if children do exist
	 */
	public function testGetFirstChild_returnsElement_ifChildrenDoExist()
	{
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group = new Group();
		$group->setChildren([$first, $middle, $last]);
		
		$expected = $first;
		$actual   = $group->getFirstChild();
		
		$this->assertSame($expected, $actual);
		
		return;
	}
	
	
	/* !getLastChild() */
	
	/**
	 * getLastChild() should return null if children do not exist
	 */
	public function testGetLastChild_returnsNull_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertNull($group->getLastChild());
		
		return;
	}
	
	/**
	 * getLastChild() should return element if children do exist
	 */
	public function testGetLastChild_returnsElement_ifChildrenDoExist()
	{
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group = new Group();
		$group->setChildren([$first, $middle, $last]);
		
		$expected = $last;
		$actual   = $group->getLastChild();
		
		$this->assertSame($expected, $actual);
		
		return;
	}
	
	
	/* !getLength() */

	/**
	 * getLength() should return integer, specifically 0, if children do not exist
	 */
	public function testGetLength_returnsInteger_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertEquals(0, $group->getLength());
		
		return;
	}
	
	/**
	 * getLength() should return integer if children do exist
	 */
	public function testGetLength_returnsInteger_ifChildrenDoExist()
	{
		$group = new Group();
		
		$group->appendChild(new Element())->appendChild(new Element());
		
		$this->assertEquals(2, $group->getLength());
		
		return;	
	}
	
	
	/* !hasChild() */
	
	/**
	 * hasChild() should throw a BadMethodCallException if $element and $index are null
	 */
	public function testHasCHild_throwsBadMethodCallException_ifElementAndIndexAreNull()
	{
		$this->setExpectedException('BadMethodCallException');
		
		$group = new Group();
		$group->hasChild(0, 0);
		
		return;
	}
	
	/**
	 * hasChild() should throw an InvalidArgumentException if $index is not an integer
	 *    or element
	 */
	public function testHasChild_throwsInvalidArgumentException_ifOneIsNotAnIntegerOrElement()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->hasChild('foo');
		
		return;
	}
	
	/**
	 * hasChild() should throw an InvalidArgumentException if $index is not an integer
	 *    or element
	 */
	public function testHasChild_throwsInvalidArgumentException_ifTwoIsNotAnIntegerOrElementOrNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->hasChild(1, 'foo');
		
		return;
	}	
	
	/**
	 * hasChild() should return false if parent has no children
	 */
	public function testHasChild_returnsFalse_ifChildrenDoNotExist()
	{
		$group = new Group();
		
		$this->assertFalse($group->hasChild(0));
		$this->assertFalse($group->hasChild(new Element()));		
		$this->assertFalse($group->hasChild(new Element(), 0));
		
		return;
	}
	
	/**
	 * hasChild() should return false if parent does not have child
	 */
	public function testHasChild_returnsFalse_ifChildDoesNotExist()
	{
		$group = new Group();
		$group->appendChild(new Text('foo'));
		
		$this->assertFalse($group->hasChild(1));
		$this->assertFalse($group->hasChild(new Element()));
		$this->assertFalse($group->hasChild(new Element(), 0));
		
		return;
	}
	
	/**
	 * hasChild() should return true if parent does have child by index
	 */
	public function testHasChild_returnsTrue_ifChildDoesExist()
	{
		$foo = new Text('foo');
		
		$group = new Group();
		$group->appendChild($foo);
		
		$this->assertTrue($group->hasChild(0));
		$this->assertTrue($group->hasChild($foo));
		$this->assertTrue($group->hasChild($foo, 0));
		
		return;
	}
		
	
	/* !insertChild() */
	
	/**
	 * insertChild() should throw an InvalidArgumentException if $index is not an integer
	 *
	 * @dataProvider  notAnIntegerProvider
	 */
	public function testInsertChild_throwsInvalidArgumentException_ifIndexIsNotAnInteger($index)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->insertChild(new Element(), $index);
		
		return;
	}
	
	/**
	 * insertChild() should throw an OutOfBoundsException if $index is too high
	 */
	public function testInsertChild_throwsOutOfBoundsException_ifIndexIsTooHigh()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->insertChild(new Element(), 999);
		
		return;
	}
	
	/**
	 * insertChild() should throw an OutOfBoundsException if $index to too low
	 */
	public function testInsertChild_throwsOutOfBoundsException_ifIndexIsTooLow()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->insertChild(new Element(), -999);
		
		return;
	}
	
	/**
	 * insertChild() should insert element if $index is between elements
	 */
	public function testInsertChild_insertsElement_ifIndexIsBetweenElements()
	{
		$child = new Element();
		
		$group = new Group();
		$group->appendChild(new Element())->appendChild(new Element());
		
		$group->insertChild($child, 1);
		
		$this->assertEquals(3, $group->getLength());
		$this->assertSame($child, $group->getChild(1));
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * insertChild() should insert element if $index is before elements
	 */
	public function testInsertChild_insertsElement_ifIndexIsBeforeElement()
	{
		$child = new Element();
		
		$group = new Group();
		$group->appendChild(new Element())->appendChild(new Element());
		
		$group->insertChild($child, 0);
		
		$this->assertEquals(3, $group->getLength());
		$this->assertSame($child, $group->getFirstChild());
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	 
	/**
	 * insertChild() should insert element if $index is after elements
	 */
	public function testInsertChild_insertsElement_ifIndexIsAfterElements()
	{
		$child = new Element();
		
		$group = new Group();
		$group->appendChild(new Element())->appendChild(new Element());
		
		$group->insertChild($child, 2);
		
		$this->assertEquals(3, $group->getLength());
		$this->assertSame($child, $group->getLastChild());
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * insertChild() should not render the group if it's not rendered
	 */
	public function testInsertChild_doesNotRender_ifGroupIsNotRendered()
	{
		$group = new Group();
		
		$this->assertFalse($group->getIsRendered());
		
		$group->insertChild(new Element(), 0);
		
		$this->assertFalse($group->getIsRendered());
		
		return;	
	}
	
	/**
	 * insertChild() should render the group if it's rendered
	 */
	public function testInsertChild_doesRender_ifGroupIsRendered()
	{
		$group = new Group();
		$group->setStyle(new \Jstewmc\Rtf\Style());
		$group->setIsRendered(true);
	
		$this->assertTrue($group->getIsRendered());
		
		$group->insertChild(new Element(), 0);
		
		$this->assertTrue($group->getIsRendered());
		
		return;	
	}
	
	
	/* !isDestination */
	
	/**
	 * isDestination() should return false if the group's first child is not the 
	 *     asterisk control symbol
	 */
	public function testIsDestination_returnsTrue_ifFirstChildIsNotAsterisk()
	{
		$group = new Group();
		$group->appendChild(new Text('foo'));
		
		$this->assertFalse($group->isDestination());
		
		return;
	}
	 
	/**
	 * isDestination() should return true if the group's first child is the asterisk
	 *     control symbol
	 */
	public function testIsDestination_returnsTrue_ifFirstChildIsAsterisk()
	{
		$group = new Group();
		$group->appendChild(new Control\Symbol\Asterisk());
		
		$this->assertTrue($group->isDestination());
		
		return;
	}
	
	
	
	/* !render() */
	
	/**
	 * render() should render if the group is empty
	 */
	public function testRender_ifGroupIsEmpty()
	{
		$group = new Group();
		
		$group->render();
		
		return;
	}
	
	/**
	 * render() should render a group of control words
	 */
	public function testRender_ifGroupIsControls()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$group = new Group();
		$group->setStyle($style);
		
		$group->appendChild(new Control\Word\B());
		$group->appendChild(new Text('foo'));
		$group->appendChild(new Control\Word\B(0));
		
		// the group's is rendered flag should be false
		$this->assertFalse($group->getIsRendered());
		
		$group->render();
		
		// the group should keep its style
		$this->assertSame($style, $group->getStyle());
		
		// get the first element
		$first = $group->getFirstChild();

		
		// the first element turns on bold so it'll have a different character state, 
		//     but the document-, section-, and paragraph-state should be the same as 
		//     the group's original style
		//
		$this->assertSame($style->getDocument(), $first->getStyle()->getDocument());
		$this->assertSame($style->getSection(), $first->getStyle()->getSection());
		$this->assertSame($style->getParagraph(), $first->getStyle()->getParagraph());
		$this->assertNotSame($style->getCharacter(), $first->getStyle()->getCharacter());
		$this->assertTrue($first->getStyle()->getCharacter()->getIsBold());
		 
		// get the second element
		$middle = $first->getNextSibling();
		
		// the middle element makes no style changes; so, the document-, section-, 
		//     paragraph-, and character-state should be the same as the first element
		//
		$this->assertSame(
			$first->getstyle()->getDocument(), 
			$middle->getStyle()->getDocument()
		);
		$this->assertSame(
			$first->getStyle()->getSection(), 
			$middle->getStyle()->getSection()
		);
		$this->assertSame(
			$first->getStyle()->getParagraph(), 
			$middle->getStyle()->getParagraph()
		);
		$this->assertSame(
			$first->getStyle()->getCharacter(), 
			$middle->getStyle()->getCharacter()
		);
		
		// get the last child
		$last = $middle->getNextSibling();
		
		// the last element turns off bold so it'll have a different character state;
		//     but the document-, section-, and paragraph-state should be the same
		//     as the middle character
		//
		$this->assertSame(
			$middle->getStyle()->getDocument(),
			$last->getStyle()->getDocument()
		);
		$this->assertSame(
			$middle->getStyle()->getSection(),
			$last->getStyle()->getSection()
		);
		$this->assertSame(
			$middle->getStyle()->getParagraph(),
			$last->getStyle()->getParagraph()
		);
		$this->assertNotSame(
			$middle->getStyle()->getCharacter(),
			$last->getStyle()->getCharacter()
		);
		$this->assertFalse($last->getStyle()->getCharacter()->getIsBold());
		
		// the group should be rendered
		$this->assertTrue($group->getIsRendered());
		
		return;
	}
	
	/**
	 * render() should render a nested group
	 */
	public function testRender_ifGroupIsGroups()
	{
		$style = new \Jstewmc\Rtf\Style();
		
		$subgroup = new Group();
		$subgroup->appendChild(new Text('foo'));
		
		$group = new Group();
		$group->setStyle($style);
		$group->appendChild($subgroup);
		
		// the group's is rendered flag should be false
		$this->assertFalse($group->getIsRendered());
		
		// render the group
		$group->render();
		
		// the group's style shouldn't change
		$this->assertSame($style, $group->getStyle());
		
		// the sub-group's document-, section-, paragraph-, and character-state should
		//     be the same
		//
		$this->assertSame(
			$group->getStyle()->getDocument(), 
			$subgroup->getStyle()->getDocument()
		);
		$this->assertSame(
			$group->getStyle()->getSection(), 
			$subgroup->getStyle()->getSection()
		);
		$this->assertSame(
			$group->getStyle()->getParagraph(), 
			$subgroup->getStyle()->getParagraph()
		);
		$this->assertSame(
			$group->getStyle()->getCharacter(), 
			$subgroup->getStyle()->getCharacter()
		);
		
		// get the subgroup's first child
		$child = $subgroup->getFirstChild();
		
		// the sub-group's first (and only) child should have the same document-,
		//     section-, paragraph-, and character-state as it's parent (the sub-group)
		//
		// apparently, assertSame() will fail here, even though the child's states 
		//     equal the subgroup's states and the subgroup's states equal the child's
		//     states
		//
		$this->assertEquals(
			$subgroup->getStyle()->getDocument(), 
			$child->getStyle()->getDocument()
		);
		$this->assertEquals(
			$subgroup->getStyle()->getSection(), 
			$child->getStyle()->getSection()
		);
		$this->assertEquals(
			$subgroup->getStyle()->getParagraph(), 
			$child->getStyle()->getParagraph()
		);
		$this->assertEquals(
			$subgroup->getStyle()->getCharacter(), 
			$child->getStyle()->getCharacter()
		);
		
		// the group's is rendered flag should be true
		$this->assertTrue($group->getIsRendered());
		
		return;
	}
	
	
	/* !prependChild() */
	
	/**
	 * prependChild() should prepend the element if zero children exist
	 */
	public function testPrependChild_prependsElement_ifZeroChildrenExist()
	{
		$child = new Element();
		
		$group = new Group();
		$group->prependChild($child);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 1);
		$this->assertSame($child, reset($group->getChildren()));
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * prependChild() should prepend the element if many children exist
	 */
	public function testPrependChild_prependsElement_ifManyChildrenExist()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$child = new Element();
			
		$group->prependChild($child);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 4);
		$this->assertSame($child, reset($group->getChildren()));
		$this->assertSame($group, $child->getParent());
		
		return;
	}
	
	/**
	 * prependChild() should not render the group if it's not rendered
	 */
	public function testPrependChild_doesNotRender_ifGroupIsNotRendered()
	{
		$group = new Group();
		
		$this->assertFalse($group->getIsRendered());
		
		$group->prependChild(new Element());
		
		$this->assertFalse($group->getIsRendered());
		
		return;	
	}
	
	/**
	 * prependChild() should render the group if it's rendered
	 */
	public function testPrependChild_doesRender_ifGroupIsRendered()
	{
		$group = new Group();
		$group->setStyle(new \Jstewmc\Rtf\Style());
		$group->setIsRendered(true);
	
		$this->assertTrue($group->getIsRendered());
		
		$group->prependChild(new Element());
		
		$this->assertTrue($group->getIsRendered());
		
		return;	
	}
	
	
	/* !removeChild() */
	
	/**
	 * removeChild() should throw an InvalidArgumentException if $element is not an integer
	 *     or element
	 *
	 * @dataProvider  notAnIntegerProvider()
	 */
	public function testRemoveChild_throwsInvalidArgumentException_ifElementIsNotAnIntegerOrElement($index)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->removeChild($index);
		
		return;
	}
	
	/**
	 * removeChild() should throw an OutOfBoundsException if $element is not a valid index
	 */
	public function testRemoveChild_throwsOutOfBoundsException_ifElementIsNotValidKey()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->removeChild(999);
		
		return;
	}
	
	/**
	 * removeChild() should throw an OutOfBoundsException if $element is not a valid child
	 *     element
	 */
	public function testRemoveChild_throwsOutOfBoundsException_ifElementIsNotAValidChild()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->removeChild(new Text('foo'));
		
		return;
	}
	
	/**
	 * removeChild() should remove and return element if $element is valid key
	 */
	public function testRemoveChild_returnElement_ifElementIsValidKey()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$removed = $group->removeChild(1);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 2);
		$this->assertEquals($first, reset($group->getChildren()));
		$this->assertEquals($last, end($group->getChildren()));
		$this->assertSame($middle, $removed);
		$this->assertNull($removed->getParent());
		
		return;
	}
	
	/**
	 * removeChild() should remove and return element if $element is valid element
	 */
	public function testRemoveChild_returnElement_ifElementIsValidElement()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$removed = $group->removeChild($middle);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 2);
		$this->assertEquals($first, reset($group->getChildren()));
		$this->assertEquals($last, end($group->getChildren()));
		$this->assertSame($middle, $removed);
		$this->assertNull($removed->getParent());
		
		return;
	}
	
	/**
	 * removeChild() should not render the group if it's not rendered
	 */
	public function testRemoveChild_doesNotRender_ifGroupIsNotRendered()
	{
		$group = new Group();
		$group->appendChild(new Element());
		
		$this->assertFalse($group->getIsRendered());
		
		$group->removeChild(0);
		
		$this->assertFalse($group->getIsRendered());
		
		return;	
	}
	
	/**
	 * removeChild() should render the group if it's rendered
	 */
	public function testRemoveChild_doesRender_ifGroupIsRendered()
	{
		$group = new Group();
		$group->appendChild(new Element());
		$group->setStyle(new \Jstewmc\Rtf\Style());
		$group->setIsRendered(true);
	
		$this->assertTrue($group->getIsRendered());
		
		$group->removeChild(0);
		
		$this->assertTrue($group->getIsRendered());
		
		return;	
	}
	
	
	/* !replaceChild() */
	
	/**
	 * replaceChild() should throw an InvalidArgumentException if $old is not an integer
	 *
	 * @dataProvider  notAnIntegerProvider
	 */
	public function testReplaceChild_throwsInvalidArgumentException_ifOldIsNotAnIntegerOrElement($old)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$group = new Group();
		$group->replaceChild($old, new Element());
		
		return;
	}
	
	/**
	 * replaceChild() should throw an OutOfBoundsException if $old is not a valid key
	 */
	public function testReplaceChild_throwsOutOfBoundsException_ifOldIsNotValidKey()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->replaceChild(999, new Element());
		
		return;
	}
	
	/**
	 * replaceChild() should throw an OutOfBoundsException if $old is not a valid child
	 */
	public function testReplaceChild_throwsOutOfBoundsException_ifOldIsNotValidChild()
	{
		$this->setExpectedException('OutOfBoundsException');
		
		$group = new Group();
		$group->replaceChild(new Element(), new Element());
		
		return;
	}
	
	/**
	 * replaceChild() should return the replaced element if $old is a valid key
	 */
	public function testReplaceChild_returnsElement_ifOldIsValidKey()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$new = new Element();
		
		$old = $group->replaceChild(1, $new);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 3);
		$this->assertEquals($first, reset($group->getChildren()));
		$this->assertEquals($last, end($group->getChildren()));
		$this->assertEquals($new, $group->getChildren()[1]);
		$this->assertEquals($old, $middle);
		$this->assertSame($group, $new->getParent());
		$this->assertNull($old->getParent());
		
		return;
	}
	
	/**
	 * replaceChild() should return the replaced element if $old is a valid child
	 */
	public function testReplaceChild_returnsElement_ifOldIsValidChild()
	{
		$group = new Group();
		
		$first  = new Element();
		$middle = new Element();
		$last   = new Element();
		
		$group->setChildren([$first, $middle, $last]);
		
		$new = new Element();
		
		$old = $group->replaceChild($middle, $new);
		
		$this->assertTrue(is_array($group->getChildren()));
		$this->assertTrue(count($group->getChildren()) == 3);
		$this->assertEquals($first, reset($group->getChildren()));
		$this->assertEquals($last, end($group->getChildren()));
		$this->assertEquals($new, $group->getChildren()[1]);
		$this->assertEquals($old, $middle);
		$this->assertSame($group, $new->getParent());
		$this->assertNull($old->getParent());
		
		return;
	}
	
	/**
	 * replaceChild() should not render the group if it's not rendered
	 */
	public function testReplaceChild_doesNotRender_ifGroupIsNotRendered()
	{
		$group = new Group();
		$group->appendChild(new Element());
		
		$this->assertFalse($group->getIsRendered());
		
		$group->replaceChild(0, new Element());
		
		$this->assertFalse($group->getIsRendered());
		
		return;	
	}
	
	/**
	 * appendChild() should render the group if it's rendered
	 */
	public function testReplaceChild_doesRender_ifGroupIsRendered()
	{
		$group = new Group();
		$group->appendChild(new Element());
		$group->setStyle(new \Jstewmc\Rtf\Style());
		$group->setIsRendered(true);
	
		$this->assertTrue($group->getIsRendered());
		
		$group->replaceChild(0, new Element());
		
		$this->assertTrue($group->getIsRendered());
		
		return;	
	}
}
