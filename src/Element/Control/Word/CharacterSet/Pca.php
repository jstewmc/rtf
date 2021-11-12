<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

/**
 * The "IBM PC code page 850" character set
 */
class Pca extends CharacterSet
{
    protected string $encoding = 'IBM850';

    public function __construct()
    {
        parent::__construct('pca');
    }
}
