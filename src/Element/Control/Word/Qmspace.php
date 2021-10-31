<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\qmspace" control word inserts a one-quarter "m" space.
 */
class Qmspace extends Word
{
    protected function toHtml(): string
    {
        return '&thinsp;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
