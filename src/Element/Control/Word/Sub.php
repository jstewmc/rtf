<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\sub" control word subscripts text and shrinks font-size according to font
 * information.
 */
class Sub extends Word
{
    public function __construct(?int $parameter = null)
    {
        parent::__construct('sub', $parameter);
    }

    public function run(): void
    {
        $this->style->getCharacter()->setIsSubscript((bool)$this->parameter);
    }
}
