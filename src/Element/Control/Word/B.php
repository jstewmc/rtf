<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\b" control word bolds characters. It is a two-state control word.
 */
class B extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('b', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsBold(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
