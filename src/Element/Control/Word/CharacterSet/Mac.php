<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

/**
 * The "Apple Macintosh" character set
 */
class Mac extends CharacterSet
{
    protected string $encoding = 'macintosh';

    public function __construct()
    {
        parent::__construct('mac');
    }
}
