<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts a non-breaking space equal to the width of the character "m" in the
 * current font-size
 *
 * Some old RTF writers will add an extra space after the "\emspace" control word
 * to trick readers unaware of "emspace" into parsing a regular space. This reader
 * will interpret that as an "emspace" and a regular space.
 */
class Emspace extends HtmlEntity
{
    protected string $entity = '&emsp;';

    public function __construct()
    {
        parent::__construct('emspace');
    }
}
