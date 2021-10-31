<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\sub" control word subscripts text and shrinks font-size according to font
 * information.
 */
class Sub extends Word
{
    /* !Public methods */

    /**
     * Runs the command
     *
     * @return  void
     */
    public function run()
    {
        $this->style->getCharacter()->setIsSubscript((bool)$this->parameter);

        return;
    }
}
