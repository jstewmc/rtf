<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Swiss, proportionally spaced sans serif fonts
 */
class Fswiss extends FontFamily
{
    protected string $fonts = 'Arial';

    public function __construct()
    {
        parent::__construct('fswiss');
    }
}
