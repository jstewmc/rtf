<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * Marks a "destination" whose text should be ignored, if not understood by the
 * RTF reader. An asterisk control symbol will always be the first control
 * symbol in a destination group.
 */
class Asterisk extends Symbol
{
    public function __construct()
    {
        parent::__construct('*');
    }
}
