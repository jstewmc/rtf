<?php

namespace Jstewmc\Rtf\Token\Group;

class Close extends Group
{
    public function __toString(): string
    {
        return '}';
    }
}
