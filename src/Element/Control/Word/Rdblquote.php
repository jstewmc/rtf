<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\rdblquote" control word inserts a right double-quotation mark.
 */
class Rdblquote extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('rdblquote', $parameter);
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
