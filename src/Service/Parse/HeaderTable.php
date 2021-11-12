<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Element\{
    Group,
    HeaderTable\FontTable
};

/**
 * Post-processing step to parse header tables
 */
class HeaderTable
{
    public function __invoke(Group $root): Group
    {
        $this->parseFontTable($root);

        return $root;
    }

    private function parseFontTable(Group $root): void
    {
        $fonttbls = $root->getControlWords('fonttbl');

        if (!$fonttbls) {
            return;
        }

        $fonttbl = reset($fonttbls);

        $group = $fonttbl->getParent();

        $table = new FontTable($group->getChildren());

        $group->replaceWith($table);
    }
}
