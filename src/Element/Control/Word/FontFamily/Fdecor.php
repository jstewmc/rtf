<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Decorative fonts
 */
class Fdecor extends FontFamily
{
    protected string $fonts = 'Old English, ITC Zapf Chancery';

    public function __construct()
    {
        parent::__construct('fdecor');
    }
}
