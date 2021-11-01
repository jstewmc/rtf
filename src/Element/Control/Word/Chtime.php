<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chtime" control word inserts the current time.
 */
class Chtime extends Word
{
    public function __construct()
    {
        parent::__construct('chtime');
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return (new \DateTime())->format('H:i:s');
    }
}
