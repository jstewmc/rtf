<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The apostrophe control symbol ("\'hh") is used to represent a non-ASCII
 * character from a Windows Code Page. The two digits "hh" are a hexadecimal
 * value for the given character on the given code page.
 *
 * The current code page is specified by the "\ansicpg" control word.
 */
class Apostrophe extends Symbol
{
    protected string $symbol = '\'';

    protected function toHtml(): string
    {
        // parameter is hexadecimal number
        return "&#x{$this->parameter};";
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
