<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\bullet" control word inserts a bullet character.
 */
class Bullet extends Word
{
    protected function toHtml(): string
    {
        return '&bull;';
    }

    protected function toText(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
