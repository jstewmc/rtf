<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chdpl" control word inserts the current date in abbreviated format (e.g.,
 * "Thu, Jul 22, 2015").
 */
class Chdpl extends Word
{
    public function __construct()
    {
        parent::__construct('chdpl');
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return (new \DateTime('now'))->format('D, j M Y');
    }
}
