<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\emdash" control word inserts an em-dash.
 */
class Emdash extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('emdash', $parameter);
    }

    protected function toHtml(): string
    {
        return '&emdash;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
