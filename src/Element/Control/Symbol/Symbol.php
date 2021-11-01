<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

class Symbol extends \Jstewmc\Rtf\Element\Control\Control
{
    /**
     * The control symbol's parameter; generally, empty, unless the symbol is an
     * apostrophe
     */
    protected string $parameter = '';

    protected string $symbol = '';

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

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function __construct($parameter = null)
    {
        if ($parameter !== null) {
            $this->parameter = $parameter;
        }

        return;
    }

    public function toRtf(): string
    {
        $rtf = '';

        if ($this->symbol) {
            $rtf = "\\{$this->symbol}{$this->parameter}";
            if ($this->isSpaceDelimited) {
                $rtf .= ' ';
            }
        }

        return $rtf;
    }
}
