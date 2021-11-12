<?php

namespace Jstewmc\Rtf\Element\Control\Word\CharacterSet;

use Jstewmc\Rtf\Element\Control\Word\Word;

abstract class CharacterSet extends Word
{
    protected string $encoding = '';

    public function getEncoding(): string
    {
        return $this->encoding;
    }
}
