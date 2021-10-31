<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\b" control word bolds characters. It is a two-state control word.
 */
class B extends Word
{
    public function run(): void
    {
        $this->style->getCharacter()->setIsBold(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
