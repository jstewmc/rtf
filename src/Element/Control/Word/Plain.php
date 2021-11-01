<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\plain" control word resets the character-formatting properties to their
 * default value (e.g., bold is "off", italic is "off", etc).
 */
class Plain extends Word
{
    public function __construct()
    {
        parent::__construct('plain');
    }

    public function run(): void
    {
        $this->style->getCharacter()->reset();
    }
}
