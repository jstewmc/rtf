<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

/**
 * Detects the well-formed document's encoding
 *
 * In a well-formed RTF document, two control words - a mandatory character set
 * and an optional code page - determine the document's character encoding:
 *
 *   1. When the character set is not "\ansi" (i.e., "\pc", "\pca", or "\mac"),
 *      the character set's encoding takes precedence.
 *   2. When the character set is "\ansi" but a code page does not exist, the
 *      default ANSI code page "windows-1252" take precedence.
 *   3. When the character set is "\ansi" and a code page does exist, it takes
 *      precendence.
 *
 * If the document is not well-formed, the $default encoding is returned.
 */
class DetectEncoding
{
    public function __invoke(Element\Group $root, string $default = 'windows-1252'): string
    {
        if (!$this->isWellFormed($root)) {
            return $default;
        }

        if ($this->codePageHasPrecedence($root)) {
            $encoding = $this->getEncodingFromCodePage($root);
        } else {
            $encoding = $this->getEncodingFromCharacterSet($root);
        }

        return $encoding;
    }

    private function isWellFormed(Element\Group $root): bool
    {
        return $this->hasLength($root) &&
            $this->hasVersion($root) &&
            $this->hasCharacterSet($root);
    }

    private function hasLength(Element\Group $root): bool
    {
        return $root->getLength() >= 2;
    }

    private function hasVersion(Element\Group $root): bool
    {
        return $root->getFirstChild() instanceof Element\Control\Word\Rtf;
    }

    private function hasCharacterSet(Element\Group $root): bool
    {
        $element = $root->getChild(1);

        return $element instanceof Element\Control\Word\Ansi ||
            $element instanceof Element\Control\Word\Pc ||
            $element instanceof Element\Control\Word\Pca ||
            $element instanceof Element\Control\Word\Mac;
    }

    private function codePageHasPrecedence(Element\Group $root): bool
    {
        return $this->isAnsiCharacterSet($root) && $this->hasCodePage($root);
    }

    private function isAnsiCharacterSet(Element\Group $root): bool
    {
        return $this->getCharacterSet($root) instanceof Element\Control\Word\Ansi;
    }

    private function hasCodePage(Element\Group $root): bool
    {
        return $root->getChild(2) instanceof Element\Control\Word\Ansicpg;
    }

    private function getEncodingFromCharacterSet(Element\Group $root): string
    {
        return $this->getCharacterSet($root)->getEncoding();
    }

    private function getCharacterSet(Element\Group $root): Element\Control\Word\Word
    {
        return $root->getChild(1);
    }

    private function getEncodingFromCodePage(Element\Group $root): string
    {
        return $this->getCodePage($root)->getEncoding();
    }

    private function getCodePage(Element\Group $root): Element\Control\Word\Ansicpg
    {
        return $root->getChild(2);
    }
}
