<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Emdash extends HtmlEntity
{
    protected string $entity = '&emdash;';

    public function __construct()
    {
        parent::__construct('emdash');
    }
}
