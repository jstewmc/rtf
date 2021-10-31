<?php

namespace Jstewmc\Rtf\Element;

/**
 * A test suite for the Element class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class ElementTest extends \PHPUnit\Framework\TestCase
{
    /* !Providers */

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

    /* !Get/set methods */

    /**
     * setParent() and getParent() should set and get the element's parent
     */
    public function testSetGetParent()
    {
        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $expected = $parent;
        $actual   = $element->getParent();

        $this->assertSame($expected, $actual);

        return;
    }

    /**
     * setStyle() and getStyle() should set and get the element's style
     */
    public function testSetGetStyle()
    {
        $style = new \Jstewmc\Rtf\Style();

        $element = new Element();
        $element->setStyle($style);

        $expected = $style;
        $actual   = $element->getStyle();

        $this->assertSame($expected, $actual);

        return;
    }


    /* !appendTo() */

    /**
     * appendTo() should append the element
     */
    public function testAppendToAppendsElement()
    {
        $group = new Group();

        $this->assertEquals([], $group->getChildren());

        $foo = new Text('foo');
        $foo->appendTo($group);

        $this->assertEquals([$foo], $group->getChildren());

        $bar = new Text('bar');
        $bar->appendTo($group);

        $this->assertEquals([$foo, $bar], $group->getChildren());

        return;
    }


    /* !getIndex() */

    /**
     * getIndex() should throw BadMethodCallException if the parent does not exist
     */
    public function testGetIndexThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();

        $element->getIndex();

        return;
    }

    /**
     * getIndex() should throw BadMethodCallException if siblings do not exist
     */
    public function testGetIndexThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->getIndex();

        return;
    }

    /**
     * getIndex() should throw BadMethodCallException if the element is not a child of its parent
     */
    public function testGetIndexThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->getIndex();

        return;
    }

    /**
     * getIndex() should return integer if the element is a child of its parent
     */
    public function testGetIndexReturnsIntegerWhenElementIsChild()
    {
        $child = new Element();

        $parent = new Group();
        $parent->appendChild($child)->appendChild(new Element());

        $this->assertEquals(0, $child->getIndex());

        return;
    }


    /* !getNextSibling() */

    /**
     * nextSibling() should throw BadMethodCallException if the element doesn't have a parent
     */
    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();
        $element->getNextSibling();

        return;
    }

    /**
     * getNextSibling() should throw a BadMethodCallException if siblings don't exist
     */
    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->getNextSibling();

        return;
    }

    /**
     * getNextSibling() should throw a BadMethodCallException if the element is not a
     *     of its parent
     */
    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->getNextSibling();

        return;
    }

    /**
     * getnextSibling() should return null if the next element does not exist
     */
    public function testGetNextSiblingReturnsNullWhenNextElementDoesNotExist()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getNextSibling());

        return;
    }

    /**
     * getNextSibling() should return next element if it exists
     */
    public function testGetNextSiblingReturnsElementWhenNextElementDoesExist()
    {
        $element = new Element();
        $next    = new Element();

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertSame($next, $element->getNextSibling());

        return;
    }


    /* !getNextText() */

    /**
     * getNextText() should throw BadMethodCallException if the element doesn't have a parent
     */
    public function testGetNextTextThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();
        $element->getNextText();

        return;
    }

    /**
     * getNextText() should throw a BadMethodCallException if siblings don't exist
     */
    public function testGetNextTextThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->getNextText();

        return;
    }

    /**
     * getNextText() should throw a BadMethodCallException if the element is not a
     *     child of its parent
     */
    public function testGetNextTextThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->getNextText();

        return;
    }

    /**
     * getNextText() should return null if the next element does not exist
     */
    public function testGetNextTextReturnsNullWhenNextElementDoesNotExist()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getNextText());

        return;
    }

    /**
     * getNextText() should return null if next element is not text
     */
    public function testGetNextTextReturnsNullWhenNextElementIsNotText()
    {
        $element = new Element();
        $next    = new Element();

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertNull($element->getNextText());

        return;
    }

    /**
     * getNextText() should return null if next element is text
     */
    public function testGetNextTextReturnsElementWhenNextElementIsText()
    {
        $element = new Element();
        $next    = new Text('');

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertSame($next, $element->getNextText());

        return;
    }



    /* !getPreviousSibling() */

    /**
     * getPreviousSibling() should throw BadMethodCallException if the parent element does not exist
     */
    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();
        $element->getPreviousSibling();

        return;
    }

    /**
     * getPreviousSibling() should throw BadMethodCallException if siblings do not exist
     */
    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->getPreviousSibling();

        return;
    }

    /**
     * getPreviousSibling() should throw BadMethodCallException if element is not child
     */
    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->getIndex();

        return;
    }

    /**
     * getPreviousSibling() should return null if previous element does not exist
     */
    public function testGetPreviousSiblingReturnsNullWhenPreviousDoesNotExist()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousSibling());

        return;
    }

    /**
     * getPreviousSibling() should return previous element if it exists
     */
    public function testGetPreviousSiblingReturnsElementWhenPreviousDoesExist()
    {
        $element  = new Element();
        $previous = new Element();

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertSame($previous, $element->getPreviousSibling());

        return;
    }


    /* !getPreviousText() */

    /**
     * getPreviousText() should throw BadMethodCallException if the parent element does not exist
     */
    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();
        $element->getPreviousText();

        return;
    }

    /**
     * getPreviousText() should throw BadMethodCallException if siblings do not exist
     */
    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->getPreviousText();

        return;
    }

    /**
     * getPreviousText() should throw BadMethodCallException if element is not child
     */
    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->getPreviousText();

        return;
    }

    /**
     * getPreviousText() should return null if previous element does not exist
     */
    public function testGetPreviousTextReturnsNullWhenPreviousDoesNotExist()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousText());

        return;
    }

    /**
     * getPreviousText() should return null if previous element is not text
     */
    public function testGetPreviousTextReturnsNullWhenPreviousIsNotText()
    {
        $element  = new Element();
        $previous = new Element();

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousText());

        return;
    }

    /**
     * getPreviousText() should return previous if previous element is text
     */
    public function testGetPreviousTextReturnsPreviousWhenPreviousIsText()
    {
        $element  = new Element();
        $previous = new Text('');

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertSame($previous, $element->getPreviousText());

        return;
    }


    /* !format() */

    /**
     * format() should throw an InvalidArgumentException if $format is not a string
     *
     * @dataProvider  notAStringProvider
     */
    public function testFormatThrowsInvalidArgumentExceptionWhenFormatIsNotAString($format)
    {
        $this->expectException(\InvalidArgumentException::class);

        $element = new Element();
        $element->format($format);

        return;
    }

    /**
     * format() should throw an InvalidArgumentException if $format is not a valid format
     */
    public function testFormatThrowsInvalidArgumentExceptionWhenFormatIsNotValid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $element = new Element();
        $element->format('foo');

        return;
    }

    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $element = new Element();

        $this->assertEquals('', $element->format('html'));

        return;
    }

    /**
     * format() should return string if format is rtf
     */
    public function testFormatReturnsStringWhenFormatIsRtf()
    {
        $element = new Element();

        $this->assertEquals('', $element->format('rtf'));

        return;
    }

    /**
     * format() should return string if format is text
     */
    public function testFormatReturnsStringWhenFormatIsText()
    {
        $element = new Element();

        $this->assertEquals('', $element->format('text'));

        return;
    }


    /* !insertAfter() */

    /**
     * insertAfter() should throw BadMethodCallException if the $element's parent does not exist
     */
    public function testInsertAfterThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->insertAfter($bar);

        return;
    }

    /**
     * insertAfter() should throw BadMethodCallException if $element's parent doesn't have
     *     children
     */
    public function testInsertAfterThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();

        $bar->setParent($group);

        $foo->insertAfter($bar);

        return;
    }

    /**
     * insertAfter() should throw BadMethodCallException if $element is not a child
     */
    public function testInsertAfterThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild(new Element());

        $bar->setParent($group);

        $foo->insertAfter($bar);

        return;
    }

    /**
     * insertAfter() should return element if $element is a child of parent
     */
    public function testInsertAfterReturnsElementWhenElementIsChild()
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $expected = $bar;
        $actual   = $bar->insertAfter($foo);

        $this->assertSame($expected, $actual);
        $this->assertSame($bar, $group->getLastChild());

        return;
    }


    /* !insertBefore() */

    /**
     * insertbefore() should throw BadMethodCallException if the $element's parent does not exist
     */
    public function testInsertBeforeThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->insertBefore($bar);

        return;
    }

    /**
     * insertBefore() should throw BadMethodCallException if $element's parent doesn't have
     *     children
     */
    public function testInsertBeforeThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();

        $bar->setParent($group);

        $foo->insertBefore($bar);

        return;
    }

    /**
     * insertBefore() should throw BadMethodCallException if $element is not a child
     */
    public function testInsertBeforeThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild(new Element());

        $bar->setParent($group);

        $foo->insertBefore($bar);

        return;
    }

    /**
     * insertBefore() should return element if $element is a child of parent
     */
    public function testInsertBeforeReturnsElementWhenElementIsChild()
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $expected = $bar;
        $actual   = $bar->insertBefore($foo);

        $this->assertSame($expected, $actual);
        $this->assertSame($bar, $group->getFirstChild());

        return;
    }


    /* !isFirstChild() */

    /**
     * isFirstChild() should throw BadMethodCallException if the $element's parent does not exist
     */
    public function testIsFirstChildThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $foo->isFirstChild();

        return;
    }

    /**
     * isFirstChild() should throw BadMethodCallException if $element's parent doesn't have
     *     children
     */
    public function testIsFirstChildThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isFirstChild();

        return;
    }

    /**
     * isFirstChild() should throw BadMethodCallException if $element is not a child
     */
    public function testIsFirstChildThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();
        $group->appendChild(new Element());

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isFirstChild();

        return;
    }

    /**
     * isFirstChild() should return false if the element is not the first child
     */
    public function testIsFirstChildReturnsFalseWhenElementIsNotFirstChild()
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild(new Element())->appendChild($foo);

        $this->assertFalse($foo->isFirstChild());

        return;
    }

    /**
     * isFirstChild() should return false if the element is the first child
     */
    public function testIsFirstChildReturnsTrueWhenElementIsFirstChild()
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild($foo)->appendChild(new Element());

        $this->assertTrue($foo->isFirstChild());

        return;
    }


    /* !isLastChild() */

    /**
     * isLastChild() should throw BadMethodCallException if the $element's parent does not exist
     */
    public function testIsLastChildThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $foo->isLastChild();

        return;
    }

    /**
     * isLastChild() should throw BadMethodCallException if $element's parent doesn't have
     *     children
     */
    public function testIsLastChildThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isLastChild();

        return;
    }

    /**
     * isLastChild() should throw BadMethodCallException if $element is not a child
     */
    public function testIsLastChildThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();
        $group->appendChild(new Element());

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isLastChild();

        return;
    }

    /**
     * isLastChild() should return false if the element is not the Last child
     */
    public function testIsLastChildReturnsFalseWhenElementIsNotLastChild()
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild($foo)->appendChild(new Element());

        $this->assertFalse($foo->isLastChild());

        return;
    }

    /**
     * isLastChild() should return false if the element is the Last child
     */
    public function testIsLastChildReturnsTrueWhenElementIsLastChild()
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild(new Element())->appendChild($foo);

        $this->assertTrue($foo->isLastChild());

        return;
    }


    /* !prependTo() */

    /**
     * prependTo() should prepend the element
     */
    public function testPrependToPrependsElement()
    {
        $group = new Group();

        $this->assertEquals([], $group->getChildren());

        $foo = new Text('foo');
        $foo->prependTo($group);

        $this->assertEquals([$foo], $group->getChildren());

        $bar = new Text('bar');
        $bar->prependTo($group);

        $this->assertEquals([$bar, $foo], $group->getChildren());

        return;
    }

    /* !putNextSibling() */

    /**
     * putNextSibling() should throw BadMethodCallException if the parent does not exist
     */
    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();

        $element->putNextSibling($element);

        return;
    }

    /**
     * putNextSibling() should throw BadMethodCallException if siblings do not exist
     */
    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->putNextSibling(new Element());

        return;
    }

    /**
     * putNextSibling() should throw BadMethodCallException if element is not child
     */
    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->putNextSibling(new Element());

        return;
    }

    /**
     * putNextSibling() should insert between elements
     */
    public function testPutNextSiblingInsertsElementWhenBetweenElements()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element)->appendChild(new Element());

        $new = new Element();

        $element->putNextSibling($new);

        $this->assertEquals(3, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));

        return;
    }

    /**
     * putNextSibling() should insert after elements
     */
    public function testPutNextSiblingInsertsElementWhenAfterElements()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $new = new Element();

        $element->putNextSibling($new);

        $this->assertEquals(2, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));

        return;
    }


    /* !putPreviousSibling() */

    /**
     * putPreviousSibling() should throw BadMethodCallException if the parent does not exist
     */
    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new Element();

        $element->putPreviousSibling($element);

        return;
    }

    /**
     * putPreviousSibling() should throw BadMethodCallException if siblings do not exist
     */
    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new Element();
        $element->setParent($parent);

        $element->putPreviousSibling(new Element());

        return;
    }

    /**
     * putPreviousSibling() should throw BadMethodCallException if element is not child
     */
    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild()
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild(new Element());

        $element = new Element();
        $element->setParent($parent);

        $element->putPreviousSibling(new Element());

        return;
    }

    /**
     * putPreviousSibling() should insert between elements
     */
    public function testPutPreviousSiblingInsertsElementWhenBeforeElements()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild($element);

        $new = new Element();

        $element->putPreviousSibling($new);

        $this->assertEquals(2, $parent->getLength());
        $this->assertSame($new, $parent->getChild(0));

        return;
    }

    /**
     * putPreviousSibling() should insert after elements
     */
    public function testPutPreviousSiblingInsertsElementWhenBetweenElements()
    {
        $element = new Element();

        $parent = new Group();
        $parent->appendChild(new Element())->appendChild($element);

        $new = new Element();

        $element->putPreviousSibling($new);

        $this->assertEquals(3, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));

        return;
    }


    /* !replaceWith() */

    /**
     * replaceWith() should throw a BadMethodCallException if the parent does not exist
     */
    public function testReplaceWithThrowsBadMethodCallExceptionWhenParentDoesNotExist()
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->replaceWith($bar);

        return;
    }

    /**
     * replaceWith() should return the replaced element if the parent does exist
     */
    public function testReplaceWithReturnsElementWhenParentDoesExist()
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $this->assertEquals([$foo], $group->getChildren());

        $replaced = $foo->replaceWith($bar);

        $this->assertSame($foo, $replaced);
        $this->assertEquals([$bar], $group->getChildren());

        return;
    }
}
