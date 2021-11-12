<?php

namespace Jstewmc\Rtf\Element\HeaderTable;

/**
 * Declares fonts for use throughout the document
 */
class FontTable extends HeaderTable
{
    public function __construct(array $children)
    {
        $this->children = $children;
    }
}
