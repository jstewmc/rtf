<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts a line-break
 */
class Line extends SpecialCharacter
{
    public function __construct()
    {
        parent::__construct('line');
    }

    protected function toHtml(): string
    {
        return '<br>';
    }

    protected function toText(): string
    {
        return "\n";
    }
}
