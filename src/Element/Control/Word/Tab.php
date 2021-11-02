<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * Inserts the tab character.
 */
class Tab extends Word
{
    public function __construct()
    {
        parent::__construct('tab');
    }

    protected function toHtml(): string
    {
        // hmmm, what is the HTML equivalent of a tab character?
        // in HTML a tab is just whitespace, how about an emspace?
        return '&emsp;';
    }

    protected function toText(): string
    {
        return "\t";
    }
}
