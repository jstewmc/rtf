<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A control word (e.g., "\foo") or symbol (e.g., "\-") token
 */
abstract class Control extends \Jstewmc\Rtf\Token\Token
{
    /**
     * A flag indicating whether or not the control word or symbol is space-
     * delimited (e.g., "\foo \bar" versus "\foo\bar"); defaults to true
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
}
