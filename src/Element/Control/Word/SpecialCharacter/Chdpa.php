<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts the current date in long format (e.g., "Thursday, July 22, 2015")
 */
class Chdpa extends SpecialCharacter
{
    public function __construct()
    {
        parent::__construct('chdpa');
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return (new \DateTime())->format('l, j F Y');
    }
}
