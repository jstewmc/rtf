<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Rdblquote extends HtmlEntity
{
    protected string $entity = '&rdquo;';

    public function __construct()
    {
        parent::__construct('rdblquote');
    }
}
