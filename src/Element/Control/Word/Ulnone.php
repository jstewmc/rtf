<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ulnone" control word stops underlining characters.
 */
class Ulnone extends Word
{
    /* !Public methods */

    /**
     * Runs the command
     *
     * @return  void
     */
    public function run()
    {
        $this->style->getCharacter()->setIsUnderline(false);

        return;
    }
}
