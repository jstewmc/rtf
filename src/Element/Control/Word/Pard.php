<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\pard" control word resets to default paragraph properties.
 */
class Pard extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('pard', $parameter);
    }

    public function run(): void
    {
        $this->style->getParagraph()->reset();
    }
}
