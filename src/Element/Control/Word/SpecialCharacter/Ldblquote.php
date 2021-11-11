<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Ldblquote extends HtmlEntity
{
    protected string $entity = '&ldquo;';

    public function __construct()
    {
        parent::__construct('ldblquote');
    }
}
