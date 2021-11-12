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
            new Token\Control\Word('colortbl'),
            new Token\Text(';'),
            (new Token\Control\Word('red'))->setParameter(0),
            (new Token\Control\Word('green'))->setParameter(0),
            (new Token\Control\Word('blue'))->setParameter(0),
            new Token\Text(';'),
            new Token\Group\Close(),
            new Token\Group\Open(),
            new Token\Control\Word('stylesheet'),
            new Token\Group\Open(),
            (new Token\Control\Word('s'))->setParameter(0),
            new Token\Text('Normal;'),
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
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Ansi())
            ->appendChild(new Element\Control\Word\Deff(0))
            ->appendChild($this->fontTable())
            ->appendChild($this->colorTable())
            ->appendChild($this->stylesheet())
            ->appendChild($this->generator())
            ->appendChild(new Element\Control\Word\Word('viewkind', 4))
            ->appendChild(new Element\Control\Word\Word('uc', 1))
            ->appendChild(new Element\Control\Word\Pard())
            ->appendChild(new Element\Control\Word\Word('lang', 1033))
            ->appendChild(new Element\Control\Word\F(0))
            ->appendChild(new Element\Control\Word\Word('fs', 20))
            ->appendChild(new Element\Text('My dog is not like other dogs.'))
            ->appendChild(new Element\Control\Word\Par())
            ->appendChild(new Element\Text('He doesn\'t care to walk, '))
            ->appendChild(new Element\Control\Word\Par())
            ->appendChild(new Element\Text('He doesn\'t bark, he doesn\'t howl.'))
            ->appendChild(new Element\Control\Word\Par())
            ->appendChild(new Element\Text('He goes "Tick, tock. Tick, tock."'))
            ->appendChild(new Element\Control\Word\Par());
    }

    private function fontTable(): Element\HeaderTable\FontTable
    {
        return (new Element\HeaderTable\FontTable())
            ->appendChild(new Element\Control\Word\Fonttbl())
            ->appendChild($this->f0Group());
    }

    private function f0Group(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\F(0))
            ->appendChild(new Element\Control\Word\FontFamily\Fnil())
            ->appendChild(new Element\Control\Word\Fcharset(0))
            ->appendChild(new Element\Text('Courier New;'));
    }

    private function colorTable(): Element\HeaderTable\ColorTable
    {
        return (new Element\HeaderTable\ColorTable())
            ->appendChild(new Element\Control\Word\Colortbl())
            ->appendChild(new Element\Text(';'))
            ->appendChild(new Element\Control\Word\Color\Red(0))
            ->appendChild(new Element\Control\Word\Color\Green(0))
            ->appendChild(new Element\Control\Word\Color\Blue(0))
            ->appendChild(new Element\Text(';'));
    }

    private function stylesheet(): Element\HeaderTable\Stylesheet
    {
        return (new Element\HeaderTable\Stylesheet())
            ->appendChild(new Element\Control\Word\Stylesheet())
            ->appendChild($this->s0Group());
    }

    private function s0Group(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Word\S(0))
            ->appendChild(new Element\Text('Normal;'));
    }

    private function generator(): Element\Group
    {
        return (new Element\Group())
            ->appendChild(new Element\Control\Symbol\Asterisk())
            ->appendChild(new Element\Control\Word\Word('generator'))
            ->appendChild(new Element\Text('Msftedit 5.41.15.1516;'));
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
