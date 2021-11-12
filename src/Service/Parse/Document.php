<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{Element, Token};

class Document
{
    private SanitizeTokens $sanitize;

    private ValidateTokens $validate;

    private ControlWord $parseControlWord;

    private ControlSymbol $parseControlSymbol;

    private HeaderTable $parseHeaderTable;

    private \SplStack $groups;

    private Element\Group $root;

    public function __construct()
    {
        $this->validate = new ValidateTokens();
        $this->sanitize = new SanitizeTokens();

        $this->parseControlWord = new ControlWord();
        $this->parseControlSymbol = new ControlSymbol();
        $this->parseHeaderTable = new HeaderTable();

        $this->reset();
    }

    public function __invoke(array $tokens): Element\Group
    {
        ($this->validate)($tokens);

        $tokens = ($this->sanitize)($tokens);

        $this->parseRoot($tokens);

        $this->parseRest($tokens);

        ($this->parseHeaderTable)($this->root);

        return $this->root;
    }

    private function parseRoot(array &$tokens): void
    {
        $this->reset();

        $this->groups->push($this->root);

        array_shift($tokens);
    }

    private function reset(): void
    {
        unset($this->groups);
        $this->groups = new \SplStack();

        unset($this->root);
        $this->root = new Element\Group();
    }

    private function parseRest(array $tokens): void
    {
        foreach ($tokens as $token) {
            if ($token instanceof Token\Group\Open) {
                $this->parseGroupOpen();
            } elseif ($token instanceof Token\Group\Close) {
                $this->parseGroupClose();
            } else {
                $this->parseGroupMember($token);
            }
        }
    }

    private function parseGroupOpen(): void
    {
        $group = new Element\Group();

        $this->relate($this->groups->top(), $group);

        $this->groups->push($group);
    }

    private function parseGroupClose(): void
    {
        $this->groups->pop();
    }

    private function parseGroupMember(Token\Token $token): void
    {
        if ($token instanceof Token\Other) {
            return;
        }

        if ($token instanceof Token\Control\Word) {
            $element = ($this->parseControlWord)($token);
        } elseif ($token instanceof Token\Control\Symbol) {
            $element = ($this->parseControlSymbol)($token);
        } elseif ($token instanceof Token\Text) {
            $element = $this->parseText($token);
        }

        $this->relate($this->groups->top(), $element);
    }

    private function relate(Element\Group $parent, Element\Element $child): void
    {
        $child->setParent($parent);

        $parent->appendChild($child);
    }

    private function parseText(Token\Text $token): Element\Text
    {
        return new Element\Text($token->getText());
    }
}
