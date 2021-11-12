<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

/**
 * Roman, proportionally spaced serif fonts
 */
class Froman extends FontFamily
{
    protected string $fonts = 'Times New Roman, Palatino';

    public function __construct()
    {
        parent::__construct('froman');
    }
}
