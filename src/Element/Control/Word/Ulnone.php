<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ulnone" control word stops underlining characters.
 */
class Ulnone extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('ulnone', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsUnderline(false);
    }
}
