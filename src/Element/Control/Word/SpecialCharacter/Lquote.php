<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Lquote extends HtmlEntity
{
    protected string $entity = '&lsquo;';

    public function __construct()
    {
        parent::__construct('lquote');
    }
}
