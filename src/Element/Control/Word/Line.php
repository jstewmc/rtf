<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\line" control word inserts a line-break.
 */
class Line extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('line', $parameter);
    }

    protected function toHtml(): string
    {
        return '<br>';
    }

    protected function toText(): string
    {
        return "\n";
    }
}
