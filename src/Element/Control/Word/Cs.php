<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Designates character style
 */
class Cs extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('cs', $parameter);
    }

    public function getNumber(): int
    {
        return $this->parameter;
    }
}
