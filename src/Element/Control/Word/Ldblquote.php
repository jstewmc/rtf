<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ldblquote" control word inserts a left double-quotation mark.
 */
class Ldblquote extends Word
{
    public function __construct()
    {
        parent::__construct('ldblquote');
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
