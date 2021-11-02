<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\strike" control word sets the character's strikethrough format property.
 * The "\strike" control word is a two-state control word.
 */
class Strike extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('strike', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsStrikethrough(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
