<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A backslash followed by a single, non-alphabetic character (aka, a symbol),
 * with or without a string parameter.
 */
class Symbol extends Control
{
    private string $parameter = '';

    private string $symbol;

    public function getParameter(): string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    public function __toString(): string
    {
        $string = "\\{$this->symbol}{$this->parameter}";

        if ($this->isSpaceDelimited) {
            $string .= ' ';
        }

        return $string;
    }

    public function hasParameter(): bool
    {
        return $this->parameter !== '';
    }
}
