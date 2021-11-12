<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Tab extends HtmlEntity
{
    /**
     * Hmmm, what is the HTML equivalent of a tab character? In HTML a tab, is
     * just whitespace, how about an emspace?
     */
    protected string $entity = '&emsp;';

    public function __construct()
    {
        parent::__construct('tab');
    }

    public function toText(): string
    {
        return "\t";
    }
}
