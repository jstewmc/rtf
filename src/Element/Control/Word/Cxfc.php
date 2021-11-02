<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxfc" control word upper-cases the next letter (i.e., "CX Force Cap")
 *
 * For example:
 *
 *     {\*\cxs PH-R}Mr.\~\cxfc
 *
 * The example above would follow "Mr." with a hard space and force the next letter
 * to be capitalized.
 *
 * The "\cxfc" control word is not an ignored control word.
 *
 * The RTF-CRE specification is ambiguous as to the proximity of the control word and
 * the text it affects. I assume the text element and the control word may be
 * separated by any number of other elements, but they must appear in the same group.
 */
class Cxfc extends Word
{
    public function __construct()
    {
        parent::__construct('cxfc');
    }

    public function run(): void
    {
        // if the control word has a next text element
        if (null !== ($text = $this->getNextText())) {
            // upper-case the first letter in the text element
            $text->setText(ucfirst($text->getText()));
        }
    }
}
