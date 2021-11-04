<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\{Element, Style};

/**
 * Renders the parse tree into the document tree
 */
class Render
{
    public function __invoke(Element\Group $root): Element\Group
    {
        $style = new Style();

        $root->setStyle($style);

        // render the root and its branches, recursively
        $root->render();

        return $root;
    }
}
