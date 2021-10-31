<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\enspace" control word
 *
 * The "\enspace" control word inserts a non-breaking space equal to the width of
 * the character "n" in the current font-size.
 *
 * Some old RTF writers will add an extra space after the "\enspace" control word
 * to trick readers unaware of "enspace" into parsing a regular space. This reader
 * will interpret that as an "enspace" and a regular space.
 */

class Enspace extends Word
{
    protected function toHtml(): string
    {
        return '&ensp;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
