<?php

namespace Jstewmc\Rtf\Element\Control\Word\SpecialCharacter;

/**
 * A special character in RTF that we base on an HTML entity for convenience.
 */
abstract class HtmlEntity extends SpecialCharacter
{
    protected string $entity = '';

    public function toHtml(): string
    {
        return $this->entity;
    }

    public function toText(): string
    {
        return html_entity_decode($this->entity);
    }
}
