<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\i" control word italicizes characters. It is a two-state control word.
 */
class I extends Word
{
    /* !Public methods */

    /**
     * Runs the command
     *
     * @return  void
     */
    public function run()
    {
        $this->style->getCharacter()->setIsItalic(
            $this->parameter === null || (bool)$this->parameter
        );

        return;
    }
}
