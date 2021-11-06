<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\pc" control word is one of the four supported character set
 * declarations, which must be declared after the "\rtf" control word. It
 * indicates the "IBM PC code page 437" character set.
 */
class Pc extends Word
{
    public function __construct()
    {
        parent::__construct('pc');
    }

    public function getEncoding(): string
    {
        return 'IBM437';
    }
}
