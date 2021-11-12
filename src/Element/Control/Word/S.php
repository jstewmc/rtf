<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Designates paragraph style
 */
class S extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('s', $parameter);
    }

    public function getNumber(): int
    {
        return $this->parameter;
    }
}
