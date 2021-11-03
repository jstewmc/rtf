<?php

namespace Jstewmc\Rtf;

class StyleTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCharacterReturnsState(): void
    {
        $this->assertInstanceOf(State\Character::class, (new Style())->getCharacter());
    }

    public function testSetCharacterReturnsSelf(): void
    {
        $style = new Style();

        $this->assertSame($style, $style->setCharacter(new State\Character()));
    }

    public function testGetDocumentReturnsState(): void
    {
        $this->assertInstanceOf(State\Document::class, (new Style())->getDocument());
    }

    public function testSetDocumentReturnsSelf(): void
    {
        $style = new Style();

        $this->assertSame($style, $style->setDocument(new State\Document()));
    }

    public function testGetParagraphReturnsState(): void
    {
        $this->assertInstanceOf(State\Paragraph::class, (new Style())->getParagraph());
    }

    public function testSetParagraphReturnsSelf(): void
    {
        $style = new Style();

        $this->assertSame($style, $style->setParagraph(new State\Paragraph()));
    }

    public function testGetSectionReturnsState(): void
    {
        $this->assertInstanceOf(State\Section::class, (new Style())->getSection());
    }

    public function testSetSectionReturnsSelf(): void
    {
        $style = new Style();

        $this->assertSame($style, $style->setSection(new State\Section()));
    }

    public function testCloneReturnsDeepCopy(): void
    {
        $style1 = new Style();

        $style2 = clone $style1;

        $this->assertNotSame($style1->getDocument(), $style2->getDocument());
        $this->assertNotSame($style1->getSection(), $style2->getSection());
        $this->assertNotSame($style1->getParagraph(), $style2->getParagraph());
        $this->assertNotSame($style1->getCharacter(), $style2->getCharacter());
    }

    public function testMergeMergesStylesWhenStatesAreEqual(): void
    {
        $style1 = new Style();
        $style2 = new Style();

        $style2->merge($style1);

        $this->assertSame($style1->getDocument(), $style2->getDocument());
        $this->assertSame($style1->getSection(), $style2->getSection());
        $this->assertSame($style1->getParagraph(), $style2->getParagraph());
        $this->assertSame($style1->getCharacter(), $style2->getCharacter());
    }

    public function testMergeDoesNotMergeStylesWhenStatesAreNotEqual(): void
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
    }
}
