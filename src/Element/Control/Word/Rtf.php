<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\rtf" control word must follow the document's opening bracket and
 * declare the major version of the RTF specification used (e.g., "\rtf1").
 */
class Rtf extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('rtf', $parameter);
    }
}
