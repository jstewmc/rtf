<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

/**
 * The "IBM PC code page 437" character set
 */
class Pc extends CharacterSet
{
    protected string $encoding = 'IBM437';

    public function __construct()
    {
        parent::__construct('pc');
    }
}
