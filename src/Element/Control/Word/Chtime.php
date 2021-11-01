<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chtime" control word inserts the current time.
 */
class Chtime extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('chtime', $parameter);
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
