<?php

namespace Jstewmc\Rtf\Element\Control\Word\Color;

use Jstewmc\Rtf\Element\Control\Word\Word;

abstract class Color extends Word
{
    public function getIndex(): int
    {
        return $this->parameter;
    }
}
