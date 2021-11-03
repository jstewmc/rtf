<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\State\Paragraph;

/**
 * The "\pard" control word resets to default paragraph properties.
 */
class Pard extends Word
{
    public function __construct()
    {
        parent::__construct('pard');
    }

    public function run(): void
    {
        $this->style->setParagraph(new Paragraph());
    }
}
