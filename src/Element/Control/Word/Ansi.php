<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ansi" control word is one of the four supported character set
 * declarations, which must be declared after the "\rtf" control word. It
 * usually indicates the "windows-1252", but you should check the "\ansicpg"
 * control word to be sure. 
 */
class Ansi extends Word
{
    public function __construct()
    {
        parent::__construct('ansi');
    }

    public function getEncoding(): string
    {
        return 'windows-1252';
    }
}
