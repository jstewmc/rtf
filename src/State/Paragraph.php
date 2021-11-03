<?php

namespace Jstewmc\Rtf\State;

class Paragraph extends State
{
    private int $index = 0;

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }
}
