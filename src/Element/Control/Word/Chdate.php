<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chdate" control word inserts the current date.
 */
class Chdate extends Word
{
    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return (new \DateTime('now'))->format('m.d.Y');
    }
}
