<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Endash extends HtmlEntity
{
    protected string $entity = '&endash;';

    public function __construct()
    {
        parent::__construct('endash');
    }
}
