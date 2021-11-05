<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\pca" control word is one of the four supported character set
 * declarations, which must be declared after the "\rtf" control word. It
 * indicates the "IBM PC code page 850" character set.
 */
class Pca extends Word
{
    public function __construct()
    {
        parent::__construct('pca');
    }

    public function getEncoding(): string
    {
        return 'IBM850';
    }
}
