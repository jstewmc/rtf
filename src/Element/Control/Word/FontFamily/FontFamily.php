<?php

namespace Jstewmc\Rtf\Element\Control\Word\FontFamily;

use Jstewmc\Rtf\Element\Control\Word\Word;

abstract class FontFamily extends Word
{
    protected string $fonts = '';

    public function getFonts(): string
    {
        return $this->fonts;
    }
}
