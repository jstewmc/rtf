<?php

namespace Jstewmc\Rtf\Element\HeaderTable;

use Jstewmc\Rtf\Element\Group;

/**
 * A group in the header with data about fonts, colors, lists, etc that can be
 * referenced throughout a document. A header table's HTML is typically CSS, and
 * it does not contain document text.
 */
abstract class HeaderTable extends Group
{
    public function __construct(array $children = [])
    {
        $this->setChildren($children);
    }
    
    public function toHtml(): string
    {
        return '';
    }

    public function toText(): string
    {
        return '';
    }
}
