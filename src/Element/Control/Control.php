<?php

namespace Jstewmc\Rtf\Element\Control;

abstract class Control extends \Jstewmc\Rtf\Element\Element
{
    /**
     * A flag indicating whether or not this control word or symbol is delimited
     * by a trailing space (defaults to true)
     */
    protected bool $isSpaceDelimited = true;

    public function getIsSpaceDelimited(): bool
    {
        return $this->isSpaceDelimited;
    }

    public function setIsSpaceDelimited(bool $isSpaceDelimited): self
    {
        $this->isSpaceDelimited = $isSpaceDelimited;

        return $this;
    }

    public function run(): void
    {
        return;
    }
}
