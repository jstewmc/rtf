<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

/**
 * The default "windows-1252" character set, but you should check the "\ansicpg"
 * control word to be sure.
 */
class Ansi extends CharacterSet
{
    protected string $encoding = 'windows-1252';

    public function __construct()
    {
        parent::__construct('ansi');
    }
}
