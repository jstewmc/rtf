<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxp" control word identifies special punctuation characters, for example,
 * the difference between the period at the end of a sentence and the period in the
 * string "Dr.".
 */
class Cxp extends Word
{
    public function __construct()
    {
        parent::__construct('cxp');
    }
}
