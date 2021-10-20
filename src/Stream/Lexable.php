<?php

namespace Jstewmc\Rtf\Stream;

trait Lexable
{
    /**
     * Returns true if the next two characters in the stream are a "literal
     * character" (i.e., a special character like "{" or "}" escaped by a
     * backslash character).
     */
    public function isOnLiteral(): bool
    {
        $next = $this->lookAhead();

        return $this->isOnBackslash() && in_array($next, ['\\', '{', '}']);
    }

    /**
     * Returns true if the next two characters in the stream are an implicit
     * paragraph (i.e., an escaped new-line or carriage-return character).
     */
    public function isOnImplicitParagraph(): bool
    {
        $next = $this->lookAhead();

        return $this->isOnBackslash() && ($next === "\n" || $next === "\r");
    }

    /**
     * Returns true if the next two characters in the stream are a control word
     * (i.e., a backslash character followed by a alphabetic like "\a")
     */
    public function isOnControlWord(): bool
    {
        $next = $this->lookAhead();

        return $this->isOnBackslash() && ctype_alpha($next);
    }

    /**
     * Returns true if the next two characters in the stream are a control
     * symbol (i.e., a backslash character followed by a non-alphabetic like
     * "\-").
     */
    public function isOnControlSymbol(): bool
    {
        $next = $this->lookAhead();

        return $this->isOnBackslash() && !ctype_alpha($next);
    }

    public function isOnGroupOpen(): bool
    {
        return $this->current() === '{';
    }

    public function isOnGroupClose(): bool
    {
        return $this->current() === '}';
    }

    public function isOnTab(): bool
    {
        return $this->current() === "\t";
    }

    /**
     * Returns true if the current character is an "other" character (i.e., an
     * un-escaped carriage-returns ("\r"), an un-escaped line-feeds ("\n"), a
     * form feed ("\f"), or a null ("\0") escape sequence.
     */
    public function isOnOther(): bool
    {
        return in_array($this->current(), ["\n", "\r", "\f", "\0"]);
    }

    public function isOnBackslash(): bool
    {
        return $this->current() === '\\';
    }

    public function isOnDigit(): bool
    {
        return ctype_digit($this->current());
    }

    public function isOnHyphen(): bool
    {
        return $this->current() === '-';
    }

    public function isOnAlphabetic(): bool
    {
        return ctype_alpha($this->current());
    }

    /**
     * Look ahead to the next character without changing the stream's internal
     * character pointer
     */
    public function lookAhead()
    {
        $next = $this->next();

        $this->previous();

        return $next;
    }
}
