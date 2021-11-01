<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class Symbol extends \Jstewmc\Rtf\Element\Control\Control
{
    protected ?string $parameter;

    protected string $symbol;

    public function getParameter(): string
    {
        return $this->parameter;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function __construct(string $symbol, ?string $parameter = null)
    {
        $this->symbol = $symbol;
        $this->parameter = $parameter;
    }

    public function toRtf(): string
    {
        $rtf = "\\{$this->symbol}{$this->parameter}";

        $rtf = $this->isSpaceDelimited ? $rtf.' ' : $rtf;

        return $rtf;
    }
}
