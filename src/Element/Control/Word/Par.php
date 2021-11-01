<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\par" control word creates a new paragraph.
 */
class Par extends Word
{
    public function __construct()
    {
        parent::__construct('par');
    }

    public function run(): void
    {
        $this->style->getParagraph()->setIndex(
            $this->style->getParagraph()->getIndex() + 1
        );
    }
}
