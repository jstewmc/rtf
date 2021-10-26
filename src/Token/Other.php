<?php

namespace Jstewmc\Rtf\Token;

/**
 * An "other" character token, which does not belong to a control word, a
 * control symbol, a group-open, a group-close, or a text token (e.g., carriage-
 * returns, line-feeds, form-feeds, and null characters ignored by the lexer).
 */
class Other extends Token
{
    private string $character;

    public function getCharacter()
    {
        return $this->character;
    }

    public function __construct(string $character)
    {
        $this->character = $character;
    }

    public function __toString(): string
    {
        return $this->character;
    }
}
