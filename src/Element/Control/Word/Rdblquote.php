<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\rdblquote" control word inserts a right double-quotation mark.
 */
class Rdblquote extends Word
{
    public function __construct()
    {
        parent::__construct('rdblquote');
    }

    protected function toHtml(): string
    {
        return '&rdquo;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
