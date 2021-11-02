<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Represents a non-ASCII Unicode character.
 *
 * The "\u" control word should be followed by a signed integer representing
 * its Unicode codepoint. For the benefit of older programs without Unicode
 * support, this must be followed by the nearest representation of the character
 * in the specified code page.
 *
 * The control word "\uc0" can be used to indicate that subsequent Unicode escape
 * sequences within the current group do not specify a substitution character.
 */
class U extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('u', $parameter);
    }

    protected function toHtml(): string
    {
        return "&#{$this->parameter};";
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
