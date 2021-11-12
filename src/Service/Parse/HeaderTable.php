<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Element;

/**
 * Post-processing step to parse header tables
 */
class HeaderTable
{
    private const HEADER_TABLE_CLASSES = [
        'fonttbl'    => Element\HeaderTable\FontTable::class,
        'colortbl'   => Element\HeaderTable\ColorTable::class,
        'stylesheet' => Element\HeaderTable\Stylesheet::class
    ];

    public function __invoke(Element\Group $root): Element\Group
    {
        foreach (self::HEADER_TABLE_CLASSES as $word => $classname) {
            $matches = $root->getControlWords($word);
            if (!$matches) {
                continue;
            }
            $match = reset($matches);
            $group = $match->getParent();
            $table = new $classname($group->getChildren());
            $group->replaceWith($table);
        }

        return $root;
    }
}
