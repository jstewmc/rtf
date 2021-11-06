<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\mac" control word is one of the four supported character set
 * declarations, which must be declared after the "\rtf" control word. It
 * indicates the "Apple Macintosh" character set.
 */
class Mac extends Word
{
    public function __construct()
    {
        parent::__construct('mac');
    }

    public function getEncoding(): string
    {
        return 'macintosh';
    }
}
