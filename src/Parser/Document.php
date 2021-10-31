<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\{Element, Token};

/**
 * Parses an array of tokens into the document's parse tree.
 */
class Document
{
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
        $this->validateTokens($tokens);

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
                // if at least a root group exists
                if ($stack->count()) {
                    if ($token instanceof Token\Group\Close) {
                        $this->parseGroupClose($stack);
                    } elseif ($token instanceof Token\Control\Word) {
                        $this->parseControlWord($token, $stack->top());
                    } elseif ($token instanceof Token\Control\Symbol) {
                        $this->parseControlSymbol($token, $stack->top());
                    } elseif ($token instanceof Token\Text) {
                        $this->parseText($token, $stack->top());
                    }
                } else { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedElse -- will refactor soon
                    // otherwise, ignore the tokens
                    // hmmm, this is good because if text preceeds the root group
                    //     (observed in wild) it's ignored as it should be; however,
                    //     it's also bad, because if an extra bracket closes the
                    //     root-group early (also observed in the wild), it's not an
                    //     error
                }
            }
        }

        return $root;
    }

    private function validateTokens(array $tokens): void
    {
        (new ValidateTokens())($tokens);
    }

    /**
     * Parses a control symbol token
     *
     * @param  Jstewnc\Rtf\Token\Control\Symbol $token  the control symbol token
     * @param  Jstewmc\Rtf\Element\Group        $group  the current group
     * @return  void
     * @since  0.1.0
     */
    protected function parseControlSymbol(Token\Control\Symbol $token, Element\Group $group)
    {
        $symbol = (new ControlSymbol())($token);

        // append the element
        $symbol->setParent($group);
        $group->appendChild($symbol);

        return;
    }

    /**
     * Parses a control word token
     *
     * @param  Jstewmc\Rtf\Token\Control\Word  $token  the control word token
     * @param  Jstewmc\Rtf\Element\Group       $group  the current group
     * @return  void
     * @since   0.1.0
     */
    protected function parseControlWord(Token\Control\Word $token, Element\Group $group)
    {
        $word = (new ControlWord())($token);

        // append the element
        $word->setParent($group);
        $group->appendChild($word);

        return;
    }

    /**
     * Parses a group-close token
     *
     * @param  SplStack                       $stack  the group stack
     * @return  void
     * @since  0.1.0
     */
    protected function parseGroupClose(\SplStack $stack)
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
    protected function parseGroupOpen(\SplStack $stack)
    {
        $group = new Element\Group();

        // if the group is not the root
        if ($stack->count() > 0) {
            // set the parent-child and child-parent relationships
            $group->setParent($stack->top());
            $stack->top()->appendChild($group);
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
    protected function parseText(Token\Text $token, Element\Group $group)
    {
        $text = new Element\Text($token->getText());

        $text->setParent($group);
        $group->appendChild($text);

        return;
    }
}
