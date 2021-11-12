<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Rquote extends HtmlEntity
{
    protected string $entity = '&rsquo;';

    public function __construct()
    {
        parent::__construct('rquote');
    }
}
