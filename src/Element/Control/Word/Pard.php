<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\pard" control word resets to default paragraph properties.
 */
class Pard extends Word
{
    /* !Public methods */

    /**
     * Runs the command
     *
     * @return  void
     */
    public function run()
    {
        $this->style->getParagraph()->reset();

        return;
    }
}
