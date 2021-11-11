<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts the current time
 */
class Chtime extends SpecialCharacter
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
