<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\par" control word creates a new paragraph.
 */
class Par extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('par', $parameter);
    }

    public function run(): void
    {
        $this->style->getParagraph()->setIndex(
            $this->style->getParagraph()->getIndex() + 1
        );
    }
}
