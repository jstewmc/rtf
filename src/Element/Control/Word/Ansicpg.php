<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ansicpg" control word should follow the "\ansi" character set
 * declaration, as the third control word in the document, to declare the ANSI
 * code page to use when converting between Unicode and ANSI.
 */
class Ansicpg extends Word
{
    /**
     * An array of `iconv` encodings, indexed by code page number.
     */
    private const ENCODINGS = [
        708  => 'ISO-8859-6',
        1252 => 'windows-1252'
    ];

    public function __construct(int $parameter)
    {
        parent::__construct('ansicpg', $parameter);
    }

    public function getEncoding(): string
    {
        if (array_key_exists($this->parameter, self::ENCODINGS)) {
            return self::ENCODINGS[$this->parameter];
        }

        return "windows-{$this->parameter}";
    }
}
