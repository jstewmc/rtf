<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\lquote" control word inserts a left single-quotation mark.
 */
class Lquote extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('lquote', $parameter);
    }

    protected function toHtml(): string
    {
        return '&lsquo;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
