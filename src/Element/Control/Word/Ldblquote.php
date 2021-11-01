<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ldblquote" control word inserts a left double-quotation mark.
 */
class Ldblquote extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('ldblquote', $parameter);
    }

    protected function toHtml(): string
    {
        return '&ldquo;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
