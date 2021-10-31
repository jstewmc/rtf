<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\{Element, Token};

class Document
{
    private SanitizeTokens $sanitize;

    private ValidateTokens $validate;

    private ControlWord $parseControlWord;

    private ControlSymbol $parseControlSymbol;

    public function __construct()
    {
        $this->validate = new ValidateTokens();
        $this->sanitize = new SanitizeTokens();

        $this->parseControlWord = new ControlWord();
        $this->parseControlSymbol = new ControlSymbol();
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
        $stack = new \SplStack();
        foreach ($tokens as $token) {
            // if the token is a group-open token
            if ($token instanceof Token\Group\Open) {
                $this->parseGroupOpen($stack);
                if ($root === null) {
                    $root = $stack->bottom();
                }
            } else {
                if ($token instanceof Token\Group\Close) {
                    $this->parseGroupClose($stack);
                } else {
                    if ($token instanceof Token\Control\Word) {
                        $element = ($this->parseControlWord)($token);
                    } elseif ($token instanceof Token\Control\Symbol) {
                        $element = ($this->parseControlSymbol)($token);
                    } elseif ($token instanceof Token\Text) {
                        $element = $this->parseText($token);
                    }
                    $this->relate($stack->top(), $element);
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

    /**
     * Parses a group-close token
     *
     * @param  SplStack                       $stack  the group stack
     * @return  void
     * @since  0.1.0
     */
    private function parseGroupClose(\SplStack $stack)
    {
        $stack->pop();

        return;
    }

    /**
     * Parses a group-open token
     *
     * @param  SplStack                      $stack  the group stack
     * @param  Jstewmc\Rtf\Element\Group     $root   the root group (optional; if
     *     omitted, defaults to null)
     * @return  void
     * @since  0.1.0
     */
    private function parseGroupOpen(\SplStack $stack)
    {
        $group = new Element\Group();

        // if the group is not the root
        if ($stack->count() > 0) {
            $this->relate($stack->top(), $group);
        }

        $stack->push($group);

        return;
    }

    /**
     * Parses a text token
     *
     * @param  Jstewmc\Rtf\Token\Text     $token  a text token
     * @param  Jstewmc\Rtf\Element\Group  $group  the current group
     * @return  void
     * @since  0.1.0
     */
    private function parseText(Token\Text $token)
    {
        return new Element\Text($token->getText());
    }
}
