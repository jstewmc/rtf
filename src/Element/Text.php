<?php

namespace Jstewmc\Rtf\Element;

class Text extends Element
{
    protected string $text;

    public function getText(): string
    {
        return $this->text;
    }

    // Some control words will mutate the element's text.
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function toHtml(): string
    {
        return htmlspecialchars($this->text, ENT_COMPAT | ENT_HTML5);
    }

    public function toRtf(): string
    {
        // escape special characters
        $text = str_replace('\\', '\\\\', $this->text);
        $text = str_replace('{', '\{', $text);
        $text = str_replace('}', '\}', $text);

        return $text;
    }

    public function toText(): string
    {
        return $this->text;
    }
}
