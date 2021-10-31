<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * Inserts a non-breaking hyphen.
 */
class Underscore extends Symbol
{
    protected $symbol = '_';

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return '-';
    }
}
