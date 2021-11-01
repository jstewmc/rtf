<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * Inserts a non-breaking hyphen.
 */
class Underscore extends Symbol
{
    public function __construct()
    {
        parent::__construct('_');
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return '-';
    }
}
