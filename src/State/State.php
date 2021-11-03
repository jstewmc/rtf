<?php

namespace Jstewmc\Rtf\State;

/**
 * A set of properties about an element, which are grouped into document-,
 * section-, paragraph-, and character-scoped states.
 */
abstract class State
{
    public function format(): string
    {
        return '';
    }
}
