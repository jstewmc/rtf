<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\emspace" control word inserts a non-breaking space equal to the width of
 * the character "m" in the current font-size.
 *
 * Some old RTF writers will add an extra space after the "\emspace" control word
 * to trick readers unaware of "emspace" into parsing a regular space. This reader
 * will interpret that as an "emspace" and a regular space.
 */
class Emspace extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('emspace', $parameter);
    }

    protected function toHtml(): string
    {
        return '&emsp;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
