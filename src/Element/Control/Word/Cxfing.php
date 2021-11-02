<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxfing" control word indicates a group of fingerspelled text.
 *
 * For example:
 *
 *     {\cxfing {\*\cxs PHRBGS}M{\*\cxs HRBGS}H{\*\cxs SRBGS}S}
 *
 * The example above would be displayed as "MHS".
 *
 * The "\cxfing" control word is not an ignored control word.
 */
class Cxfing extends Word
{
    public function __construct()
    {
        parent::__construct('cxfing');
    }
}
