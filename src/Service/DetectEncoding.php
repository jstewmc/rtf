<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element\{
    Group,
    Control\Word,
    Control\Word\CharacterSet
};

/**
 * Detects a (well-formed) document's encoding
 *
 * In a well-formed RTF document, two control words in the header - a mandatory
 * character set and an optional code page - determine the document's character
 * encoding:
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
    public function __invoke(Group $root, string $default = 'windows-1252'): string
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

    private function isWellFormed(Group $root): bool
    {
        return $this->hasLength($root) &&
            $this->hasVersion($root) &&
            $this->hasCharacterSet($root);
    }

    private function hasLength(Group $root): bool
    {
        return $root->getLength() >= 2;
    }

    private function hasVersion(Group $root): bool
    {
        return $root->getFirstChild() instanceof Word\Rtf;
    }

    private function hasCharacterSet(Group $root): bool
    {
        return $root->getChild(1) instanceof CharacterSet\CharacterSet;
    }

    private function codePageHasPrecedence(Group $root): bool
    {
        return $this->isAnsiCharacterSet($root) && $this->hasCodePage($root);
    }

    private function isAnsiCharacterSet(Group $root): bool
    {
        return $this->getCharacterSet($root) instanceof CharacterSet\Ansi;
    }

    private function hasCodePage(Group $root): bool
    {
        return $root->hasChild(2) && $root->getChild(2) instanceof Word\Ansicpg;
    }

    private function getEncodingFromCharacterSet(Group $root): string
    {
        return $this->getCharacterSet($root)->getEncoding();
    }

    private function getCharacterSet(Group $root): CharacterSet\CharacterSet
    {
        return $root->getChild(1);
    }

    private function getEncodingFromCodePage(Group $root): string
    {
        return $this->getCodePage($root)->getEncoding();
    }

    private function getCodePage(Group $root): Word\Ansicpg
    {
        return $root->getChild(2);
    }
}
