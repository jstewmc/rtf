<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\i" control word italicizes characters. It is a two-state control word.
 */
class I extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('i', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsItalic(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
