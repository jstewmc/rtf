<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\line" control word inserts a line-break.
 */
class Line extends Word
{
    protected function toHtml(): string
    {
        return '<br>';
    }

    protected function toText(): string
    {
        return "\n";
    }
}
