<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Stream,
    Token
};

class Text
{
    public function __invoke(Stream $stream): Token\Text
    {
        $text = '';

        while (false !== $stream->current()) {
            if ($stream->isOnOther()) {
                // if the current character is an "other" character, ignore it
                $stream->next();
                continue;
            } elseif ($stream->isOnGroupOpen() || $stream->isOnGroupClose()) {
                // if the current character is the current group closing or it's
                // a new sub-group opening, rollback to the previous character
                // (so it isn't consumed) and short-circuit
                $stream->previous();
                break;
            } elseif ($stream->isOnLiteral()) {
                // if the current character is a backslash and it's used to
                // escape a literal character, ignore the backslash and append
                // the special character
                $text .= $stream->next();
            } elseif ($stream->isOnBackslash()) {
                // if the current character is a backslash (i.e., the start of a
                // control word/symbol), rollback to the previous character (so
                // it isn't consumed) and short-circuit
                $stream->previous();
                break;
            } else {
                // otherwise, it's text!
                $text .= $stream->current();
            }

            $stream->next();
        }

        return new Token\Text($text);
    }
}
