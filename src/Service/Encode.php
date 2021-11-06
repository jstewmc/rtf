<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

/**
 * Once a document has been parsed, its encoding can be detected and the
 * appropriate elements updated.
 */
class Encode
{
    private DetectEncoding $detectEncoding;

    public function __construct()
    {
        $this->detectEncoding = new DetectEncoding();
    }

    public function __invoke(Element\Group $root): void
    {
        $encoding = ($this->detectEncoding)($root);

        $this->encodeApostrophes($root, $encoding);
    }

    private function encodeApostrophes(Element\Group $root, string $encoding): void
    {
        $elements = $root->getControlSymbols('\'');

        foreach ($elements as $element) {
            $element->setEncoding($encoding);
        }
    }
}
