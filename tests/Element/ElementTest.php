<?php

namespace Jstewmc\Rtf\Element;

use Jstewmc\Rtf\Style;

class ElementTest extends \PHPUnit\Framework\TestCase
{
    public function testSetParentReturnsSelf(): void
    {
        $element = new TestElement();

        $this->assertSame($element, $element->setParent(new Group()));
    }

    public function testGetParentReturnsParentOrNull(): void
    {
        $this->assertNull((new TestElement())->getParent());
    }

    public function testSetStyleReturnsSelf(): void
    {
        $element = new TestElement();

        $this->assertSame($element, $element->setStyle(new Style()));
    }

    public function testGetStyleReturnsStyleOrNull(): void
    {
        $this->assertNull((new TestElement())->getStyle());
    }

    public function testAppendToWhenElementDoesNotHaveChildren(): void
    {
        $group = new Group();

        $element = new Text('foo');

        $element->appendTo($group);

        $this->assertEquals([$element], $group->getChildren());
    }

    public function testGetIndexThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new TestElement())->getIndex();
    }

    public function testGetIndexThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        // not calling `$parent->appendChild();` creates asymmetry

        $element->getIndex();
    }

    public function testGetIndexThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->getIndex();
    }

    public function testGetIndexReturnsIntegerWhenElementIsChild(): void
    {
        $child = new TestElement();

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild($child);

        $this->assertEquals(1, $child->getIndex());
    }

    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new TestElement())->getNextSibling();
    }

    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->getNextSibling();
    }

    public function testGetNextSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->getNextSibling();
    }

    public function testGetNextSiblingReturnsNullWhenNextElementDoesNotExist(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getNextSibling());
    }

    public function testGetNextSiblingReturnsElementWhenNextElementDoesExist(): void
    {
        $element = new TestElement();
        $next    = new TestElement();

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertSame($next, $element->getNextSibling());
    }

    public function testGetNextTextThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new TestElement())->getNextText();
    }

    public function testGetNextTextThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->getNextText();
    }

    public function testGetNextTextThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->getNextText();
    }

    public function testGetNextTextReturnsNullWhenNextElementDoesNotExist(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getNextText());
    }

    public function testGetNextTextReturnsNullWhenNextElementIsNotText(): void
    {
        $element = new TestElement();
        $next    = new TestElement();

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertNull($element->getNextText());
    }

    public function testGetNextTextReturnsElementWhenNextElementIsText(): void
    {
        $element = new TestElement();
        $next    = new Text('');

        $parent = new Group();
        $parent->appendChild($element)->appendChild($next);

        $element->setParent($parent);

        $this->assertSame($next, $element->getNextText());
    }

    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new TestElement())->getPreviousSibling();
    }

    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->getPreviousSibling();
    }

    public function testGetPreviousSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->getIndex();
    }

    public function testGetPreviousSiblingReturnsNullWhenPreviousDoesNotExist(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousSibling());
    }

    public function testGetPreviousSiblingReturnsElementWhenPreviousDoesExist(): void
    {
        $element  = new TestElement();
        $previous = new TestElement();

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertSame($previous, $element->getPreviousSibling());
    }

    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new TestElement())->getPreviousText();
    }

    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->getPreviousText();
    }

    public function testGetPreviousTextThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->getPreviousText();
    }

    public function testGetPreviousTextReturnsNullWhenPreviousDoesNotExist(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousText());
    }

    public function testGetPreviousTextReturnsNullWhenPreviousIsNotText(): void
    {
        $element  = new TestElement();
        $previous = new TestElement();

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertNull($element->getPreviousText());
    }

    public function testGetPreviousTextReturnsPreviousWhenPreviousIsText(): void
    {
        $element  = new TestElement();
        $previous = new Text('');

        $parent = new Group();
        $parent->appendChild($previous)->appendChild($element);

        $element->setParent($parent);

        $this->assertSame($previous, $element->getPreviousText());
    }

    public function testFormatThrowsInvalidArgumentExceptionWhenFormatIsNotAString(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new TestElement())->format('foo');
    }

    public function testFormatThrowsInvalidArgumentExceptionWhenFormatIsNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new TestElement())->format('foo');
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals('', (new TestElement())->format('html'));
    }

    public function testFormatReturnsStringWhenFormatIsRtf(): void
    {
        $this->assertEquals('', (new TestElement())->format('rtf'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals('', (new TestElement())->format('text'));
    }

    public function testInsertAfterThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->insertAfter($bar);
    }

    public function testInsertAfterThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();

        $bar->setParent($group);

        $foo->insertAfter($bar);
    }

    public function testInsertAfterThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild(new TestElement());

        $bar->setParent($group);

        $foo->insertAfter($bar);
    }

    public function testInsertAfterReturnsElementWhenElementIsChild(): void
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $expected = $bar;
        $actual   = $bar->insertAfter($foo);

        $this->assertSame($expected, $actual);
        $this->assertSame($bar, $group->getLastChild());
    }

    public function testInsertBeforeThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->insertBefore($bar);
    }

    public function testInsertBeforeThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();

        $bar->setParent($group);

        $foo->insertBefore($bar);
    }

    public function testInsertBeforeThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild(new TestElement());

        $bar->setParent($group);

        $foo->insertBefore($bar);
    }

    public function testInsertBeforeReturnsElementWhenElementIsChild(): void
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $expected = $bar;
        $actual   = $bar->insertBefore($foo);

        $this->assertSame($expected, $actual);
        $this->assertSame($bar, $group->getFirstChild());
    }

    public function testIsFirstChildThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new Text('foo'))->isFirstChild();
    }

    public function testIsFirstChildThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isFirstChild();
    }

    public function testIsFirstChildThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();
        $group->appendChild(new TestElement());

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isFirstChild();
    }

    public function testIsFirstChildReturnsFalseWhenElementIsNotFirstChild(): void
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild(new TestElement())->appendChild($foo);

        $this->assertFalse($foo->isFirstChild());
    }

    public function testIsFirstChildReturnsTrueWhenElementIsFirstChild(): void
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild($foo)->appendChild(new TestElement());

        $this->assertTrue($foo->isFirstChild());
    }

    public function testIsLastChildThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new Text('foo'))->isLastChild();
    }

    public function testIsLastChildThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isLastChild();
    }

    public function testIsLastChildThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $group = new Group();
        $group->appendChild(new TestElement());

        $foo = new Text('foo');
        $foo->setParent($group);

        $foo->isLastChild();
    }

    public function testIsLastChildReturnsFalseWhenElementIsNotLastChild(): void
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild($foo)->appendChild(new TestElement());

        $this->assertFalse($foo->isLastChild());
    }

    public function testIsLastChildReturnsTrueWhenElementIsLastChild(): void
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild(new TestElement())->appendChild($foo);

        $this->assertTrue($foo->isLastChild());
    }

    public function testPrependToPrependsElement(): void
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

    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new TestElement();

        $element->putNextSibling($element);
    }

    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->putNextSibling(new TestElement());
    }

    public function testPutNextSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->putNextSibling(new TestElement());
    }

    public function testPutNextSiblingInsertsElementWhenBetweenElements(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element)->appendChild(new TestElement());

        $new = new TestElement();

        $element->putNextSibling($new);

        $this->assertEquals(3, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));
    }

    public function testPutNextSiblingInsertsElementWhenAfterElements(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $new = new TestElement();

        $element->putNextSibling($new);

        $this->assertEquals(2, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));
    }

    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $element = new TestElement();

        $element->putPreviousSibling($element);
    }

    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenSiblingsDoNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();

        $element = new TestElement();
        $element->setParent($parent);

        $element->putPreviousSibling(new TestElement());
    }

    public function testPutPreviousSiblingThrowsBadMethodCallExceptionWhenElementIsNotChild(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild(new TestElement());

        $element = new TestElement();
        $element->setParent($parent);

        $element->putPreviousSibling(new TestElement());
    }

    public function testPutPreviousSiblingInsertsElementWhenBeforeElements(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild($element);

        $new = new TestElement();

        $element->putPreviousSibling($new);

        $this->assertEquals(2, $parent->getLength());
        $this->assertSame($new, $parent->getChild(0));
    }

    public function testPutPreviousSiblingInsertsElementWhenBetweenElements(): void
    {
        $element = new TestElement();

        $parent = new Group();
        $parent->appendChild(new TestElement())->appendChild($element);

        $new = new TestElement();

        $element->putPreviousSibling($new);

        $this->assertEquals(3, $parent->getLength());
        $this->assertSame($new, $parent->getChild(1));
    }

    public function testReplaceWithThrowsBadMethodCallExceptionWhenParentDoesNotExist(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $foo = new Text('foo');
        $bar = new Text('bar');

        $foo->replaceWith($bar);
    }

    public function testReplaceWithReturnsElementWhenParentDoesExist(): void
    {
        $foo = new Text('foo');
        $bar = new Text('bar');

        $group = new Group();
        $group->appendChild($foo);

        $this->assertEquals([$foo], $group->getChildren());

        $replaced = $foo->replaceWith($bar);

        $this->assertSame($foo, $replaced);
        $this->assertEquals([$bar], $group->getChildren());
    }
}
