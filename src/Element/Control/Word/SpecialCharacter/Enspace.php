<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * Inserts a non-breaking space equal to the width of the character "n" in the
 * current font-size
 *
 * Some old RTF writers will add an extra space after the "\enspace" control word
 * to trick readers unaware of "enspace" into parsing a regular space. This reader
 * will interpret that as an "enspace" and a regular space.
 */
class Enspace extends HtmlEntity
{
    protected string $entity = '&ensp;';

    public function __construct()
    {
        parent::__construct('enspace');
    }
}
