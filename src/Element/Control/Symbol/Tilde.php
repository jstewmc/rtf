<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * Inserts a non-breaking space
 */
class Tilde extends Symbol
{
    protected $symbol = '~';

    protected function toHtml(): string
    {
        return '&nbsp;';
    }

    protected function toText(): string
    {
        return html_entity_decode('&nbsp;');
    }
}
