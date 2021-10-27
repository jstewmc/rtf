<?php

namespace Jstewmc\Rtf\Token;

/**
 * A token represents an object in the RTF language (e.g., a control word,
 * a control symbol, a group-open, a group-close, or a plain-text character).
 */
abstract class Token
{
    abstract public function __toString(): string;
}
