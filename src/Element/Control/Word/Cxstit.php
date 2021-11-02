<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxstit" control word indicates a group of stitched text (i.e., "CX STITched").
 *
 * For example:
 *
 *     {\cxstit {\*\cxs PHFPLT}M\_{\*\cxs HFPLT}H\_{\*\cxs SFPLT}S}
 *
 * The example above would be displayed at "M-H-S" with non-breaking hyphens.
 *
 * The "\cxstit" control word is not an ignored command group.
 */
class Cxstit extends Word
{
    public function __construct()
    {
        parent::__construct('cxstit');
    }
}
