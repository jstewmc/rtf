<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Follows the character set declaration and specifies the font to use for text
 * without without an explicit reference to a font
 */
class Deff extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('deff', $parameter);
    }

    public function getNumber(): int
    {
        return $this->parameter;
    }
}
