<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\bullet" control word inserts a bullet character.
 */
class Bullet extends Word
{
    public function __construct()
    {
        parent::__construct('bullet');
    }

    protected function toHtml(): string
    {
        return '&bull;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
