<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Introduces the font table group
 */
class Fonttbl extends Word
{
    public function __construct()
    {
        parent::__construct('fonttbl');
    }
}
