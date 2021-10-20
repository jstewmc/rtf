<?php

namespace Jstewmc\Rtf\Stream;

interface Stream
{
    public function current();

    public function next();

    public function previous();

    /**
     * Returns true if the next two characters in the stream are a "literal
     * character" (i.e., a special character like "{" or "}" escaped by a
     * backslash character).
     */
    public function isOnLiteral(): bool;

    /**
     * Returns true if the next two characters in the stream are an implicit
     * paragraph (i.e., an escaped new-line or carriage-return character).
     */
    public function isOnImplicitParagraph(): bool;

    /**
     * Returns true if the next two characters in the stream are a control word
     * (i.e., a backslash character followed by a alphabetic like "\a")
     */
    public function isOnControlWord(): bool;

    /**
     * Returns true if the next two characters in the stream are a control
     * symbol (i.e., a backslash character followed by a non-alphabetic like
     * "\-").
     */
    public function isOnControlSymbol(): bool;

    public function isOnGroupOpen(): bool;

    public function isOnGroupClose(): bool;

    public function isOnTab(): bool;

    /**
     * Returns true if the current character is an "other" character (i.e., an
     * un-escaped carriage-returns ("\r"), an un-escaped line-feeds ("\n"), a
     * form feed ("\f"), or a null ("\0") escape sequence.
     */
    public function isOnOther(): bool;

    public function isOnBackslash(): bool;

    public function isOnDigit(): bool;

    public function isOnHyphen(): bool;

    public function isOnAlphabetic(): bool;

    /**
     * Looks ahead to the next character without changing the stream's internal
     * character pointer
     *
     * @return  string|false
     */
    public function lookAhead();
}
