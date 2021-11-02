<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ul" control word
 *
 * The "\ul" control word underlines characters. Keep in mind, the "\ul" control
 * word is turned "off" by the "\ulnone" control word. The "\ul0" control word
 * turns off all underlining for the group.
 */
class Ul extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('ul', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsUnderline(
            $this->parameter === null || (bool)$this->parameter
        );
    }
}
