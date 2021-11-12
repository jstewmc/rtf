<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Introduces the color table group
 */
class Colortbl extends Word
{
    public function __construct()
    {
        parent::__construct('colortbl');
    }
}
