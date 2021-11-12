<?php

namespace Jstewmc\Rtf\Element;

use Jstewmc\Rtf\Style;

class GroupTest extends \PHPUnit\Framework\TestCase
{
    public function testGetChildrenReturnsArray(): void
    {
        $this->assertEquals([], (new Group())->getChildren());
    }

    public function testSetChildrenReturnsSelf(): void
    {
        $group = new Group();

        $this->assertSame($group, $group->setChildren([]));
    }

    public function testSetChildrenSetsParent(): void
    {
        $child = new Control\Word\Word('foo');

        $group = new Group();
        $group->setChildren([$child]);

        $this->assertSame($group, $child->getParent());
    }

    public function testGetIsRenderedReturnsBool(): void
    {
        $this->assertFalse((new Group())->getIsRendered());
    }

    public function testSetIsRenderedReturnsSelf(): void
    {
        $group = new Group();

        $this->assertSame($group, $group->setIsRendered(true));
    }

    public function testToStringReturnsStringWhenChildrenDoNotExist(): void
    {
        $this->assertEquals('{}', (string)(new Group()));
    }

    public function testToStringReturnsStringWhenChildrenDoExist(): void
    {
        $group = new Group();

        $group
            ->appendChild(new Control\Word\B())
            ->appendChild(new Text('foo'))
            ->appendChild(new Control\Word\B(0));

        $this->assertEquals('{\b foo\b0 }', (string)$group);
    }

    public function testAppendChildAppendsChild(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild($child);

        $this->assertEquals(1, $group->getLength());
    }

    public function testAppendChildSetsParent(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild($child);

        $this->assertSame($group, $child->getParent());
    }

    public function testAppendChildSetsIndex(): void
    {
        $group = new Group();

        $group->setChildren([new TestElement()]);

        $child = new TestElement();

        $group->appendChild($child);

        $children = $group->getChildren();

        $this->assertSame($child, end($children));
    }

    public function testAppendChildDoesNotRenderWhenGroupIsNotRendered(): void
    {
        $group = new Group();

        $this->assertFalse($group->getIsRendered());

        $group->appendChild(new TestElement());

        $this->assertFalse($group->getIsRendered());
    }

    public function testAppendChildRendersWhenGroupIsRendered(): void
    {
        $group = new Group();
        $group->setStyle(new Style());
        $group->setIsRendered(true);

        $this->assertTrue($group->getIsRendered());

        $group->appendChild(new TestElement());

        $this->assertTrue($group->getIsRendered());
    }

    public function testFormatReturnsStringWhenFormatIsHtml(): void
    {
        $group = new Group();

        $group
            ->appendChild(new Control\Word\B())
            ->appendChild(new Text('foo'))
            ->appendChild(new Control\Word\B(0));

        $group->setStyle(new Style());

        $group->render();

        $this->assertEquals(
            '<section style=""><p style=""><span style="font-weight: bold;">foo',
            $group->format('html')
        );
    }

    public function testFormatReturnsStringWhenFormatIsRtf(): void
    {
        $group = new Group();

        $group
            ->appendChild(new Control\Word\B())
            ->appendChild(new Text('foo'))
            ->appendChild(new Control\Word\B(0));

        $this->assertEquals('{\b foo\b0 }', $group->format('rtf'));
    }

    public function testFormatReturnsStringWhenFormatIsText(): void
    {
        $group = new Group();

        $group
            ->appendChild(new Control\Word\B())
            ->appendChild(new Text('foo'))
            ->appendChild(new Control\Word\B(0));

        $this->assertEquals('foo', $group->format('text'));
    }

    public function testFormatReturnsStringWhenGroupIsDestination(): void
    {
        $group = new Group();

        $group
            ->appendChild(new Control\Symbol\Asterisk())
            ->appendChild(new Control\Word\Word('foo'))
            ->appendChild(new Text('bar'));

        $this->assertEquals('', $group->format('text'));
    }

    public function testGetChildThrowsOutOfBoundsExceptionWhenIndexIsNotValid(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->getChild(999);
    }

    public function testGetChildReturnsElementWhenIndexIsValid(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild($child);

        $this->assertSame($child, $group->getChild(0));
    }

    public function testGetControlWordsThrowsInvalidArgumentExceptionWhenParameterIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Group())->getControlWords('foo', []);
    }

    public function testGetControlWordsReturnsArrayWhenChildrenDoNotExist(): void
    {
        $this->assertEquals([], (new Group())->getControlWords('foo'));
    }

    public function testGetControlWordsReturnsArrayWhenChildDoesNotExist(): void
    {
        $group = new Group();

        $group->appendChild(new Text('foo'));

        $this->assertEquals([], $group->getControlWords('bar'));
    }

    public function testGetControlWordsReturnsArrayWhenChildDoesExist(): void
    {
        $one = new Control\Word\B();
        $foo = new Text('foo');
        $two = new Control\Word\B(0);

        $group = new Group();

        $group->appendChild($one)->appendChild($foo)->appendChild($two);

        $this->assertEquals([$one, $two], $group->getControlWords('b'));
    }

    public function testGetControlWordsReturnsArrayWhenChildIsGroup(): void
    {
        $one = new Control\Word\B();
        $two = new Control\Word\B();

        $group = new Group();

        $group
            ->appendChild($one)
            ->appendChild((new Group())
                ->appendChild($two));

        $this->assertEquals([$one, $two], $group->getControlWords('b'));
    }

    public function testGetControlSymbolsThrowsInvalidArgumentExceptionWhenParameterIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Group())->getControlSymbols('+', []);
    }

    public function testGetControlSymbolsReturnsArrayWhenChildrenDoNotExist(): void
    {
        $this->assertEquals([], (new Group())->getControlSymbols('+'));
    }

    public function testGetControlSymbolsReturnsArrayWhenChildDoesNotExist(): void
    {
        $group = new Group();

        $group->appendChild(new Text('foo'));

        $this->assertEquals([], $group->getControlSymbols('+'));
    }

    public function testGetControlSymbolsReturnsArrayWhenChildDoesExist()
    {
        $one = new Control\Symbol\Tilde();
        $foo = new Text('foo');
        $two = new Control\Symbol\Tilde();

        $group = new Group();

        $group->appendChild($one)->appendChild($foo)->appendChild($two);

        $this->assertEquals([$one, $two], $group->getControlSymbols('~'));
    }

    public function testGetControlSymbolsReturnsArrayWhenChildIsGroup(): void
    {
        $one = new Control\Symbol\Tilde('~');
        $two = new Control\Symbol\Tilde('~');

        $group = new Group();

        $group
            ->appendChild($one)
            ->appendChild((new Group())
                ->appendChild($two));

        $this->assertEquals([$one, $two], $group->getControlSymbols('~'));

        return;
    }

    public function testGetChildIndexReturnsFalseWhenChildrenDoNotExist(): void
    {
        $group = new Group();

        $this->assertFalse($group->getChildIndex(new Text('foo')));
    }

    public function testGetChildIndexReturnsFalseWhenChildDoesNotExist(): void
    {
        $group = new Group();

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group->appendChild($foo);

        $this->assertFalse($group->getChildIndex($bar));
    }

    public function testGetChildIndexReturnsIntegerWhenChildDoesExist(): void
    {
        $group = new Group();

        $foo = new Text('foo');
        $bar = new Text('bar');

        $group->appendChild($foo)->appendChild($bar);

        $this->assertEquals(1, $group->getChildIndex($bar));
    }

    public function testGetFirstChildReturnsNullWhenChildrenDoNotExist(): void
    {
        $this->assertNull((new Group())->getFirstChild());
    }

    public function testGetFirstChildReturnsElementWhenChildrenDoExist(): void
    {
        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group = new Group();
        $group->setChildren([$first, $middle, $last]);

        $this->assertSame($first, $group->getFirstChild());
    }

    public function testGetLastChildReturnsNullWhenChildrenDoNotExist(): void
    {
        $this->assertNull((new Group())->getLastChild());
    }

    public function testGetLastChildReturnsElementWhenChildrenDoExist(): void
    {
        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group = new Group();
        $group->setChildren([$first, $middle, $last]);

        $expected = $last;
        $actual   = $group->getLastChild();

        $this->assertSame($last, $group->getLastChild());
    }

    public function testGetLengthReturnsIntegerWhenChildrenDoNotExist(): void
    {
        $this->assertEquals(0, (new Group())->getLength());
    }

    public function testGetLengthReturnsIntegerWhenChildrenDoExist(): void
    {
        $group = new Group();

        $group->appendChild(new TestElement())->appendChild(new TestElement());

        $this->assertEquals(2, $group->getLength());
    }

    public function testHasChildThrowsInvalidArgumentExceptionWhenOneIsNotAnIntegerOrElement(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Group())->hasChild('foo');
    }

    public function testHasChildReturnsFalseWhenChildrenDoNotExist(): void
    {
        $group = new Group();

        $this->assertFalse($group->hasChild(0));
        $this->assertFalse($group->hasChild(new TestElement()));
        $this->assertFalse($group->hasChild(new TestElement(), 0));
    }

    public function testHasChildReturnsFalseWhenChildDoesNotExist(): void
    {
        $group = new Group();

        $group->appendChild(new Text('foo'));

        $this->assertFalse($group->hasChild(1));
        $this->assertFalse($group->hasChild(new TestElement()));
        $this->assertFalse($group->hasChild(new TestElement(), 0));
    }

    public function testHasChildReturnsTrueWhenChildDoesExist(): void
    {
        $foo = new Text('foo');

        $group = new Group();
        $group->appendChild($foo);

        $this->assertTrue($group->hasChild(0));
        $this->assertTrue($group->hasChild($foo));
        $this->assertTrue($group->hasChild($foo, 0));
    }

    public function testInsertChildThrowsOutOfBoundsExceptionWhenIndexIsTooHigh(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->insertChild(new TestElement(), 999);
    }

    public function testInsertChildThrowsOutOfBoundsExceptionWhenIndexIsTooLow(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->insertChild(new TestElement(), -999);
    }

    public function testInsertChildInsertsElementWhenIndexIsBetweenElements(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild(new TestElement())->appendChild(new TestElement());

        $group->insertChild($child, 1);

        $this->assertEquals(3, $group->getLength());
        $this->assertSame($child, $group->getChild(1));
        $this->assertSame($group, $child->getParent());
    }

    public function testInsertChildInsertsElementWhenIndexIsBeforeElement(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild(new TestElement())->appendChild(new TestElement());

        $group->insertChild($child, 0);

        $this->assertEquals(3, $group->getLength());
        $this->assertSame($child, $group->getFirstChild());
        $this->assertSame($group, $child->getParent());
    }

    public function testInsertChildInsertsElementWhenIndexIsAfterElements(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild(new TestElement())->appendChild(new TestElement());

        $group->insertChild($child, 2);

        $this->assertEquals(3, $group->getLength());
        $this->assertSame($child, $group->getLastChild());
        $this->assertSame($group, $child->getParent());
    }

    public function testInsertChildDoesNotRenderWhenGroupIsNotRendered(): void
    {
        $group = new Group();

        $this->assertFalse($group->getIsRendered());

        $group->insertChild(new TestElement(), 0);

        $this->assertFalse($group->getIsRendered());
    }

    public function testInsertChildDoesRenderWhenGroupIsRendered(): void
    {
        $group = new Group();
        $group->setStyle(new \Jstewmc\Rtf\Style());
        $group->setIsRendered(true);

        $this->assertTrue($group->getIsRendered());

        $group->insertChild(new TestElement(), 0);

        $this->assertTrue($group->getIsRendered());
    }

    public function testIsDestinationReturnsTrueWhenFirstChildIsNotAsterisk(): void
    {
        $group = new Group();
        $group->appendChild(new Text('foo'));

        $this->assertFalse($group->isDestination());
    }

    public function testIsDestinationReturnsTrueWhenFirstChildIsAsterisk(): void
    {
        $group = new Group();
        $group->appendChild(new Control\Symbol\Asterisk());

        $this->assertTrue($group->isDestination());
    }

    public function testRenderWhenGroupIsControls(): void
    {
        $style = new Style();

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
        $this->assertSame($style->getDocument(), $first->getStyle()->getDocument());
        $this->assertSame($style->getSection(), $first->getStyle()->getSection());
        $this->assertSame($style->getParagraph(), $first->getStyle()->getParagraph());
        $this->assertNotSame($style->getCharacter(), $first->getStyle()->getCharacter());
        $this->assertTrue($first->getStyle()->getCharacter()->getIsBold());

        // get the second element
        $middle = $first->getNextSibling();

        // the middle element makes no style changes; so, the document-, section-,
        //     paragraph-, and character-state should be the same as the first element
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
    }

    public function testRenderWhenGroupIsGroups(): void
    {
        $style = new Style();

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

    public function testPrependChildAddsElement(): void
    {
        $child = new TestElement();

        $group = new Group();

        $group->prependChild($child);

        $this->assertEquals(1, $group->getLength());
    }

    public function testPrependChildPrependsElement(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild(new TestElement());
        $group->prependChild($child);

        $children = $group->getChildren();

        $this->assertEquals($child, reset($children));
    }

    public function testPrependChildSetsParent(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->prependChild($child);

        $this->assertSame($group, $child->getParent());
    }

    public function testPrependChildPrependsElementWhenManyChildrenExist(): void
    {
        $group = new Group();

        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group->setChildren([$first, $middle, $last]);

        $child = new TestElement();

        $group->prependChild($child);

        $children = $group->getChildren();

        $this->assertSame($child, reset($children));
    }

    public function testPrependChildDoesNotRenderWhenGroupIsNotRendered(): void
    {
        $group = new Group();

        $this->assertFalse($group->getIsRendered());

        $group->prependChild(new TestElement());

        $this->assertFalse($group->getIsRendered());
    }

    public function testPrependChildDoesRenderWhenGroupIsRendered(): void
    {
        $group = new Group();
        $group->setStyle(new Style());
        $group->setIsRendered(true);

        $this->assertTrue($group->getIsRendered());

        $group->prependChild(new TestElement());

        $this->assertTrue($group->getIsRendered());
    }

    public function testRemoveChildThrowsInvalidArgumentExceptionWhenArgumentIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Group())->removeChild('foo');
    }

    public function testRemoveChildThrowsOutOfBoundsExceptionWhenElementIsNotValidKey(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->removeChild(999);
    }

    public function testRemoveChildThrowsOutOfBoundsExceptionWhenElementIsNotAValidChild(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->removeChild(new Text('foo'));
    }

    public function testRemoveChildReturnsElementWhenElementIsValidKey(): void
    {
        $group = new Group();

        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group->setChildren([$first, $middle, $last]);

        $removed = $group->removeChild(1);

        $children = $group->getChildren();

        $this->assertEquals($first, reset($children));
        $this->assertEquals($last, end($children));
        $this->assertSame($middle, $removed);
    }

    public function testRemoveChildUnsetsParent(): void
    {
        $child = new TestElement();

        $group = new Group();
        $group->appendChild($child);

        $group->removeChild(0);

        $this->assertNull($child->getParent());
    }

    public function testRemoveChildReturnsElementWhenElementIsValidElement(): void
    {
        $group = new Group();

        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group->setChildren([$first, $middle, $last]);

        $removed = $group->removeChild($middle);

        $children = $group->getChildren();

        $this->assertEquals($first, reset($children));
        $this->assertEquals($last, end($children));
        $this->assertSame($middle, $removed);
    }

    public function testRemoveChildDoesNotRenderWhenGroupIsNotRendered(): void
    {
        $group = new Group();
        $group->appendChild(new TestElement());

        $this->assertFalse($group->getIsRendered());

        $group->removeChild(0);

        $this->assertFalse($group->getIsRendered());
    }

    public function testRemoveChildDoesRenderWhenGroupIsRendered(): void
    {
        $group = new Group();
        $group->appendChild(new TestElement());
        $group->setStyle(new Style());
        $group->setIsRendered(true);

        $this->assertTrue($group->getIsRendered());

        $group->removeChild(0);

        $this->assertTrue($group->getIsRendered());
    }

    public function testReplaceChildThrowsInvalidArgumentExceptionWhenOldIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Group())->replaceChild('foo', new TestElement());
    }

    public function testReplaceChildThrowsOutOfBoundsExceptionWhenOldIsNotValidKey(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->replaceChild(999, new TestElement());
    }

    public function testReplaceChildThrowsOutOfBoundsExceptionWhenOldIsNotValidChild()
    {
        $this->expectException(\OutOfBoundsException::class);

        (new Group())->replaceChild(new TestElement(), new TestElement());
    }

    public function testReplaceChildReturnsElementWhenOldIsValidKey(): void
    {
        $group = new Group();

        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group->setChildren([$first, $middle, $last]);

        $new = new TestElement();

        $old = $group->replaceChild(1, $new);

        $children = $group->getChildren();

        $this->assertEquals($first, reset($children));
        $this->assertEquals($last, end($children));
        $this->assertEquals($new, $group->getChildren()[1]);
        $this->assertEquals($old, $middle);
        $this->assertSame($group, $new->getParent());
        $this->assertNull($old->getParent());
    }

    public function testReplaceChildReturnsElementWhenOldIsValidChild(): void
    {
        $group = new Group();

        $first  = new TestElement();
        $middle = new TestElement();
        $last   = new TestElement();

        $group->setChildren([$first, $middle, $last]);

        $new = new TestElement();

        $old = $group->replaceChild($middle, $new);

        $this->assertTrue(is_array($group->getChildren()));
        $this->assertTrue(count($group->getChildren()) == 3);

        $children = $group->getChildren();

        $this->assertEquals($first, reset($children));
        $this->assertEquals($last, end($children));
        $this->assertEquals($new, $group->getChildren()[1]);
        $this->assertEquals($old, $middle);
        $this->assertSame($group, $new->getParent());
        $this->assertNull($old->getParent());
    }

    public function testReplaceChildDoesNotRenderWhenGroupIsNotRendered(): void
    {
        $group = new Group();
        $group->appendChild(new TestElement());

        $this->assertFalse($group->getIsRendered());

        $group->replaceChild(0, new TestElement());

        $this->assertFalse($group->getIsRendered());
    }

    public function testReplaceChildDoesRenderWhenGroupIsRendered(): void
    {
        $group = new Group();
        $group->appendChild(new TestElement());
        $group->setStyle(new \Jstewmc\Rtf\Style());
        $group->setIsRendered(true);

        $this->assertTrue($group->getIsRendered());

        $group->replaceChild(0, new TestElement());

        $this->assertTrue($group->getIsRendered());
    }
}
