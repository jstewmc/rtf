<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\i" control word italicizes characters. It is a two-state control word.
 */
class I extends Word
{
    public function __construct()
    {
        parent::__construct('i');
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsItalic(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
