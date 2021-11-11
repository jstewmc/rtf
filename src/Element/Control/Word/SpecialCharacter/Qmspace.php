<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Qmspace extends HtmlEntity
{
    protected string $entity = '&thinsp;';

    public function __construct()
    {
        parent::__construct('qmspace');
    }
}
