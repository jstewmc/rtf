<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts the current date in abbreviated format (e.g., "Thu, Jul 22, 2015")
 */
class Chdpl extends SpecialCharacter
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
