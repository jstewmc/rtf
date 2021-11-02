<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxds" control word glues the words on either side of the control word
 * together without a space between them (i.e., "CX Delete Space").
 *
 * For example:
 *
 *     {\*\cxs -G}\cxds ing
 *
 * The example above is the suffix "ing".
 *
 * The "\cxds" control word is not an ignored control word.
 *
 * The RTF-CRE specification is ambiguous as to the proximity of the control word and
 * the text it affects. I assume the text element and the control word may be
 * separated by any number of other elements, but they must appear in the same group.
 */
class Cxds extends Word
{
    public function __construct()
    {
        parent::__construct('cxds');
    }

    public function run(): void
    {
        // if the control word has a previous text element
        if (null !== ($text = $this->getPreviousText())) {
            // if the last character in the text is the space character
            if (substr($text->getText(), -1, 1) == ' ') {
                // remove it
                $text->setText(substr($text->getText(), 0, -1));
            }
        }

        // if the control word has a next text element
        if (null !== ($text = $this->getNextText())) {
            // if the first character in the text is the space character
            if (substr($text->getText(), 0, 1) == ' ') {
                // remove it
                $text->setText(substr($text->getText(), 1));
            }
        }
    }
}
