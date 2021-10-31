<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\strike" control word
 *
 * The "\strike" control word sets the character's strikethrough format property.
 * The "\strike" control word is a two-state control word.
 */
class Strike extends Word
{
    /* !Public methods */

    /**
     * Runs the command
     *
     * @return  void
     */
    public function run()
    {
        return $this->style->getCharacter()->setIsStrikethrough(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
