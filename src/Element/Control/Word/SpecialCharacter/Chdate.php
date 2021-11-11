<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts the current date
 */
class Chdate extends SpecialCharacter
{
    public function __construct()
    {
        parent::__construct('chdate');
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return (new \DateTime('now'))->format('m.d.Y');
    }
}
