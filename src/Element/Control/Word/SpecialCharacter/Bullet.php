<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

class Bullet extends HtmlEntity
{
    protected string $entity = '&bull;';

    public function __construct()
    {
        parent::__construct('bullet');
    }
}
