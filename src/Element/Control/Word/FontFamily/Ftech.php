<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Technical, symbol, and mathematical fonts
 */
class Ftech extends FontFamily
{
    protected string $fonts = 'Symbol';

    public function __construct()
    {
        parent::__construct('ftech');
    }
}
