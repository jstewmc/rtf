<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\{Element, Token};

class Document
{
    private SanitizeTokens $sanitize;

    private ValidateTokens $validate;

    private ControlWord $parseControlWord;

    private ControlSymbol $parseControlSymbol;

    private \SplStack $groups;


    public function __construct()
    {
        $this->validate = new ValidateTokens();
        $this->sanitize = new SanitizeTokens();

        $this->parseControlWord = new ControlWord();
        $this->parseControlSymbol = new ControlSymbol();

        $this->groups = new \SplStack();
    }

    /**
     * Parses tokens into a parse tree
     *
     * @param  Jstewmc\Rtf\Token[]  $tokens  an array of tokens to parse
     * @return  Jstewmc\Rtf\Element\Group|null  the parse tree's root group (or
     *     null if $tokens is an empty array)
     * @throws  InvalidArgumentException  if groups are mismatched in $tokens
     * @since  0.1.0
     * @since  0.4.2  add test for group-open and group-close mismatch
     */
    public function parse(array $tokens): ?Element\Group
    {
        ($this->validate)($tokens);

        $tokens = ($this->sanitize)($tokens);

        $root  = null;

        // loop through the tokens
        foreach ($tokens as $token) {
            // if the token is a group-open token
            if ($token instanceof Token\Group\Open) {
                $this->parseGroupOpen();
                if ($root === null) {
                    $root = $this->groups->bottom();
                }
            } else {
                if ($token instanceof Token\Group\Close) {
                    $this->parseGroupClose();
                } else {
                    if ($token instanceof Token\Control\Word) {
                        $element = ($this->parseControlWord)($token);
                    } elseif ($token instanceof Token\Control\Symbol) {
                        $element = ($this->parseControlSymbol)($token);
                    } elseif ($token instanceof Token\Text) {
                        $element = $this->parseText($token);
                    }
                    $this->relate($this->groups->top(), $element);
                }
            }
        }

        return $root;
    }

    private function relate(Element\Group $parent, Element\Element $child): void
    {
        $child->setParent($parent);

        $parent->appendChild($child);
    }

    private function parseGroupClose(): void
    {
        $this->groups->pop();
    }

    private function parseGroupOpen(): void
    {
        $group = new Element\Group();

        // if the group is not the root
        if ($this->groups->count() > 0) {
            $this->relate($this->groups->top(), $group);
        }

        $this->groups->push($group);
    }

    private function parseText(Token\Text $token): Element\Text
    {
        return new Element\Text($token->getText());
    }
}
