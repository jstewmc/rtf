<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class Fcharset extends Word
{
    public function __construct(int $parameter)
    {
        parent::__construct('fcharset', $parameter);
    }
}
