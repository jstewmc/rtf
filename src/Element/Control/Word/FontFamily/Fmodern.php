<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Fixed-pitch serif and sans serif fonts
 */
class Fmodern extends FontFamily
{
    protected string $fonts = 'Courier New, Pica';

    public function __construct()
    {
        parent::__construct('fmodern');
    }
}
