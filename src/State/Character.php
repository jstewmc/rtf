<?php

namespace Jstewmc\Rtf\State;

/**
 * A character state defines character-level properties such as formatting,
 * borders, shading, and visibility.
 */
class Character extends State
{
    private bool $isBold = false;

    private bool $isItalic = false;

    private bool $isStrikethrough = false;

    private bool $isSubscript = false;

    private bool $isSuperscript = false;

    private bool $isUnderline = false;

    private bool $isVisible = true;

    public function getIsBold(): bool
    {
        return $this->isBold;
    }

    public function getIsItalic(): bool
    {
        return $this->isItalic;
    }

    public function getIsSubscript(): bool
    {
        return $this->isSubscript;
    }

    public function getIsSuperscript(): bool
    {
        return $this->isSuperscript;
    }

    public function getIsStrikethrough(): bool
    {
        return $this->isStrikethrough;
    }

    public function getIsUnderline(): bool
    {
        return $this->isUnderline;
    }

    public function getIsVisible(): bool
    {
        return $this->isVisible;
    }

    public function setIsBold(bool $isBold): self
    {
        $this->isBold = $isBold;

        return $this;
    }

    public function setIsItalic(bool $isItalic): self
    {
        $this->isItalic = $isItalic;

        return $this;
    }

    public function setIsSubscript(bool $isSubscript): self
    {
        $this->isSubscript = $isSubscript;

        return $this;
    }

    public function setIsSuperscript(bool $isSuperscript): self
    {
        $this->isSuperscript = $isSuperscript;

        return $this;
    }

    public function setIsStrikethrough(bool $isStrikethrough): self
    {
        $this->isStrikethrough = $isStrikethrough;

        return $this;
    }

    public function setIsUnderline(bool $isUnderline): self
    {
        $this->isUnderline = $isUnderline;

        return $this;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function format(string $format = 'css'): string
    {
        if (strtolower($format) !== 'css') {
            throw new \InvalidArgumentException(
                "format must be 'css'"
            );
        }

        $declarations = [];

        if ($this->isBold) {
            $declarations[] = 'font-weight: bold';
        }

        if ($this->isItalic) {
            $declarations[] = 'font-style: italic';
        }

        if ($this->isSubscript) {
            $declarations[] = 'vertical-align: sub';
            $declarations[] = 'font-size: smaller';
        }

        if ($this->isSuperscript) {
            $declarations[] = 'vertical-align: super';
            $declarations[] = 'font-size: smaller';
        }

        if ($this->isStrikethrough) {
            $declarations[] = 'text-decoration: line-through';
        }

        if ($this->isUnderline) {
            $declarations[] = 'text-decoration: underline';
        }

        if (! $this->isVisible) {
            $declarations[] = 'display: none';
        }

        $string = '';
        if (!empty($declarations)) {
            $string = implode('; ', $declarations).';';
        }

        return $string;
    }
}
