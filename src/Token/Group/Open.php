<?php

namespace Jstewmc\Rtf\Token\Group;

class Open extends Group
{
    public function __toString(): string
    {
        return '{';
    }
}
