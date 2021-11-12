<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Designates section style
 */
class Ds extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('ds', $parameter);
    }

    public function getNumber(): int
    {
        return $this->parameter;
    }
}
