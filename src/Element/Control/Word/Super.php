<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\super" control word
 *
 * The "\super" control word superscripts text and shrinks font-size according
 * to font information.
 */
class Super extends Word
{
    public function run(): void
    {
        $this->style->getCharacter()->setIsSuperscript(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
