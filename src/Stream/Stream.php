<?php

namespace Jstewmc\Rtf\Stream;

interface Stream
{
    public function current();

    public function next();

    public function previous();

    /**
     * A "literal character" is a special character like "{" or "}" escaped by a
     * backslash character.
     */
    public function isOnLiteral(): bool;

    /**
     * An "implicit paragraph" is an escaped new-line or carriage-return
     * character.
     */
    public function isOnImplicitParagraph(): bool;

    /**
     * A control word is a backslash character followed by a alphabetic (e.g.,
     * "\a").
     */
    public function isOnControlWord(): bool;

    /**
     * A control symbol is a backslash character followed by a non-alphabetic
     * (e.g., "\-").
     */
    public function isOnControlSymbol(): bool;

    public function isOnGroupOpen(): bool;

    public function isOnGroupClose(): bool;

    public function isOnTab(): bool;

    /**
     * An "other" character is an un-escaped carriage-return ("\r"), an
     * un-escaped line-feed ("\n"), a form feed ("\f"), or a null ("\0") escape
     * sequence.
     */
    public function isOnOther(): bool;

    public function isOnBackslash(): bool;

    public function isOnDigit(): bool;

    public function isOnHyphen(): bool;

    public function isOnAlphabetic(): bool;

    public function isOnSpace(): bool;

    public function isOnApostrophe(): bool;
}
