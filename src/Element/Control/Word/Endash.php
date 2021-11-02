<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\endash" control word inserts an en-dash.
 */
class Endash extends Word
{
    public function __construct()
    {
        parent::__construct('endash');
    }

    protected function toHtml(): string
    {
        return '&endash;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
