<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\rquote" control word inserts a right single-quotation mark.
 */
class Rquote extends Word
{
    public function __construct()
    {
        parent::__construct('rquote');
    }

    protected function toHtml(): string
    {
        return '&rsquo;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
