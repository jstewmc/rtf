<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\fN" control words define each font available in the document, and are
 * used to reference that font throughout the document.
 */
class F extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('f', $parameter);
    }

    public function getNumber(): int
    {
        return $this->parameter;
    }
}
