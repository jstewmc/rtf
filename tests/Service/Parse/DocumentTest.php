<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{Element, Token};

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeThrowsInvalidArgumentExceptionWhenTokensIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Document())([]);
    }

    public function testInvokeThrowsInvalidArgumentExceptionWhenRootIsMissing(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Document())([new Token\Text('foo')]);
    }

    public function testInvokeThrowsInvalidArgumentExceptionWhenGroupsMismatched(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $tokens = [
            new Token\Group\Open(),
            new Token\Group\Close(),
            new Token\Group\Close()
        ];

        (new Document())($tokens);
    }

    public function testInvokeReturnsRootWhenTokensPreceedRootGroupOpen(): void
    {
        $tokens = [
            new Token\Text('foo'),
            new Token\Group\Open(),
            new Token\Group\Close()
        ];

        $this->assertEquals(new Element\Group(), (new Document())($tokens));
    }

    public function testInvokeParsesGroups(): void
    {
        $tokens = [
            new Token\Group\Open(),
            new Token\Group\Close()
        ];

        $this->assertEquals(new Element\Group(), (new Document())($tokens));
    }

    public function testInvokeParsesNestedGroups(): void
    {
        $this->assertEquals(
            $this->nestedGroupRoot(),
            (new Document())($this->nestedGroupTokens())
        );
    }

    private function nestedGroupTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Group\Open(),
            new Token\Group\Open(),
            new Token\Group\Close(),
            new Token\Group\Close(),
            new Token\Group\Close()
        ];
    }

    private function nestedGroupRoot(): Element\Group
    {
        $group1 = new Element\Group();
        $group2 = new Element\Group();
        $group3 = new Element\Group();

        $group2->setParent($group1);
        $group1->appendChild($group2);

        $group3->setParent($group2);
        $group2->appendChild($group3);

        return $group1;
    }

    public function testInvokeParsesSpecificControlWords(): void
    {
        $this->assertEquals(
            $this->specificControlWordRoot(),
            (new Document())($this->specificControlWordTokens())
        );
    }

    private function specificControlWordTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Control\Word('b'),
            new Token\Group\Close()
        ];
    }

    private function specificControlWordRoot(): Element\Group
    {
        $root = new Element\Group();

        $word = new Element\Control\Word\B();
        $word->setParent($root);

        $root->appendChild($word);

        return $root;
    }

    public function testInvokeParsesGenericControlWord(): void
    {
        $this->assertEquals(
            $this->genericControlWordRoot(),
            (new Document())($this->genericControlWordTokens())
        );
    }

    private function genericControlWordTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Control\Word('foo'),
            new Token\Group\Close()
        ];
    }

    private function genericControlWordRoot(): Element\Group
    {
        $root = new Element\Group();

        $word = new Element\Control\Word\Word('foo');

        $word->setParent($root);
        $root->appendChild($word);

        return $root;
    }

    public function testInvokeParsesSpecificControlSymbol(): void
    {
        $this->assertEquals(
            $this->specificControlSymbolRoot(),
            (new Document())($this->specificControlSymbolTokens())
        );
    }

    private function specificControlSymbolTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Control\Symbol('*'),
            new Token\Group\Close()
        ];
    }

    private function specificControlSymbolRoot(): Element\Group
    {
        $root = new Element\Group();

        $symbol = new Element\Control\Symbol\Asterisk();
        $symbol->setParent($root);

        $root->appendChild($symbol);

        return $root;
    }

    public function testInvokeParsesGenericControlSymbol(): void
    {
        $this->assertEquals(
            $this->genericControlSymbolRoot(),
            (new Document())($this->genericControlSymbolTokens())
        );
    }

    private function genericControlSymbolTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Control\Symbol('#'),
            new Token\Group\Close()
        ];
    }

    private function genericControlSymbolRoot(): Element\Group
    {
        $root = new Element\Group();

        $symbol = new Element\Control\Symbol\Symbol('#');
        $symbol->setParent($root);

        $root->appendChild($symbol);

        return $root;
    }

    public function testInvokeParsesText(): void
    {
        $this->assertEquals(
            $this->textRoot(),
            (new Document())($this->textTokens())
        );
    }

    private function textTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Text('foo'),
            new Token\Group\Close()
        ];
    }

    private function textRoot(): Element\Group
    {
        $root = new Element\Group();

        $text = new Element\Text('foo');
        $text->setParent($root);

        $root->appendChild($text);

        return $root;
    }


    public function testInvokeParsesDocumentSmall(): void
    {
        $this->assertEquals(
            $this->documentRoot(),
            (new Document())($this->documentTokens())
        );
    }

    private function documentTokens(): array
    {
        return [
            new Token\Group\Open(),
            (new Token\Control\Word('rtf'))->setParameter(1),
            new Token\Control\Word('ansi'),
            (new Token\Control\Word('deff'))->setParameter(0),
            new Token\Group\Open(),
            new Token\Control\Word('fonttbl'),
            new Token\Group\Open(),
            (new Token\Control\Word('f'))->setParameter(0),
            new Token\Control\Word('fnil'),
            (new Token\Control\Word('fcharset'))->setParameter(0),
            new Token\Text('Courier New;'),
            new Token\Group\Close(),
            new Token\Group\Close(),
            new Token\Group\Open(),
            new Token\Control\Symbol('*'),
            new Token\Control\Word('generator'),
            new Token\Text('Msftedit 5.41.15.1516;'),
            new Token\Group\Close(),
            (new Token\Control\Word('viewkind'))->setParameter(4),
            (new Token\Control\Word('uc'))->setParameter(1),
            new Token\Control\Word('pard'),
            (new Token\Control\Word('lang'))->setParameter(1033),
            (new Token\Control\Word('f'))->setParameter(0),
            (new Token\Control\Word('fs'))->setParameter(20),
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
    }

    private function documentRoot(): Element\Group
    {
        $groupA = new Element\Group();

        $a_1 = new Element\Control\Word\Word('rtf', 1);
        $a_1->setParent($groupA);

        $a_2 = new Element\Control\Word\Word('ansi');
        $a_2->setParent($groupA);

        $a_3 = new Element\Control\Word\Word('deff', 0);
        $a_3->setParent($groupA);

        $groupB = new Element\Group();
        $groupB->setParent($groupA);

        $b_1 = new Element\Control\Word\Word('fonttbl');
        $b_1->setParent($groupB);

        $groupC = new Element\Group();
        $groupC->setParent($groupB);

        $c_1 = new Element\Control\Word\Word('f', 0);
        $c_1->setParent($groupC);

        $c_2 = new Element\Control\Word\Word('fnil');
        $c_2->setParent($groupC);

        $c_3 = new Element\Control\Word\Word('fcharset', 0);
        $c_3->setParent($groupC);

        $c_4 = new Element\Text('Courier New;');
        $c_4->setParent($groupC);

        $groupD = new Element\Group();
        $groupD->setParent($groupA);

        $d_1 = new Element\Control\Symbol\Asterisk();
        $d_1->setParent($groupD);

        $d_2 = new Element\Control\Word\Word('generator');
        $d_2->setParent($groupD);

        $d_3 = new Element\Text('Msftedit 5.41.15.1516;');
        $d_3->setParent($groupD);

        // back to a

        $a_4 = new Element\Control\Word\Word('viewkind', 4);
        $a_4->setParent($groupA);

        $a_5 = new Element\Control\Word\Word('uc', 1);
        $a_5->setParent($groupA);

        $a_6 = new Element\Control\Word\Pard();
        $a_6->setParent($groupA);

        $a_7 = new Element\Control\Word\Word('lang', 1033);
        $a_7->setParent($groupA);

        $a_8 = new Element\Control\Word\Word('f', 0);
        $a_8->setParent($groupA);

        $a_9 = new Element\Control\Word\Word('fs', 20);
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

        return $groupA;
    }

    public function testInvokeParsesOtherCharacterTokens(): void
    {
        $this->assertEquals(
            $this->otherRoot(),
            (new Document())($this->otherTokens())
        );
    }

    private function otherTokens(): array
    {
        return [
            new Token\Group\Open(),
            new Token\Other("\r"),
            new Token\Group\Close()
        ];
    }

    private function otherRoot(): Element\Group
    {
        return new Element\Group();
    }
}
