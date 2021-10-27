<?php

namespace Jstewmc\Rtf\Token;

/**
 * A plain-text token (i.e., everything that isn't a group-open, group-close,
 * control word, or control symbol is plain-text). Special characters (i.e.,
 * "\", "{", and "}") are escaped with a backslash ("\").
 */
class Text extends Token
{
    private string $text;

    public function getText(): string
    {
        return $this->text;
    }

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
