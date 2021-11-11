<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Script fonts
 */
class Fscript extends FontFamily
{
    protected string $fonts = 'Cursive';

    public function __construct()
    {
        parent::__construct('froman');
    }
}
