<?php

namespace Jstewmc\Rtf\Element;

use Jstewmc\Rtf\Style;

/**
 * A component of an RTF document, like an HTML tag or an XML node. Elements
 * can be groups, text, control words, and control symbols.
 */
abstract class Element
{
    /**
     * The element's parent group, which is set during the parsing process.
     * Every element has a parent, except for the root group.
     */
    protected ?Group $parent = null;

    /**
     * The element's style, the sum of its document-, section-, paragraph-, and
     * character-states, which is set during the rendering process.
     */
    protected ?Style $style = null;

    public function getParent(): ?Group
    {
        return $this->parent;
    }

    public function setParent(Group $parent = null): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(Style $style = null): self
    {
        $this->style = $style;

        return $this;
    }

    public function __toString(): string
    {
        return $this->toRtf();
    }

    public function appendTo(Group $group): self
    {
        $group->appendChild($this);

        return $this;
    }

    public function getIndex(): int
    {
        $this->validateParent();

        $index = $this->parent->getChildIndex($this);

        if ($index === false) {
            throw new \BadMethodCallException(
                'element must be child of parent'
            );
        }

        return $index;
    }

    public function getNextSibling(): ?Element
    {
        $next = null;

        $index = $this->getIndex();

        if ($this->parent->hasChild($index + 1)) {
            $next = $this->parent->getChild($index + 1);
        }

        return $next;
    }

    public function getNextText(): ?Text
    {
        $text = null;

        $next = $this->getNextSibling();

        while ($next !== null && ! $next instanceof Text) {
            $next = $next->getNextSibling();
        }

        if ($next !== null && $next instanceof Text) {
            $text = $next;
        }

        return $text;
    }

    public function getPreviousSibling(): ?Element
    {
        $previous = null;

        $index = $this->getIndex();

        if ($this->parent->hasChild($index - 1)) {
            $previous = $this->parent->getChild($index - 1);
        }

        return $previous;
    }

    public function getPreviousText(): ?Text
    {
        $text = null;

        $previous = $this->getPreviousSibling();

        while ($previous !== null && ! $previous instanceof Text) {
            $previous = $previous->getPreviousSibling();
        }

        if ($previous !== null && $previous instanceof Text) {
            $text = $previous;
        }

        return $text;
    }

    public function format(string $format = 'rtf'): string
    {
        $format = strtolower($format);

        if ($format === 'htm' || $format === 'html') {
            $string = $this->toHtml();
        } elseif ($format === 'rtf') {
            $string = $this->toRtf();
        } elseif ($format === 'text') {
            $string = $this->toText();
        } else {
            throw new \InvalidArgumentException(
                "format must be 'rtf', 'html', or 'text'"
            );
        }

        return $string;
    }

    public function insertAfter(Element $element): self
    {
        $index = $element->getIndex();

        $element->getParent()->insertChild($this, $index + 1);

        return $this;
    }

    public function insertBefore(Element $element): self
    {
        $index = $element->getIndex();

        $element->getParent()->insertChild($this, $index);

        return $this;
    }

    public function isFirstChild(): bool
    {
        return $this->getIndex() === 0;
    }

    public function isLastChild(): bool
    {
        return $this->getIndex() === $this->parent->getLength() - 1;
    }

    public function prependTo(Group $group): self
    {
        $group->prependChild($this);

        return $this;
    }

    public function putNextSibling(Element $element): self
    {
        $index = $index = $this->getIndex();

        $this->parent->insertChild($element, $index + 1);

        return $this;
    }

    public function putPreviousSibling(Element $element): self
    {
        $index = $this->getIndex();

        $this->parent->insertChild($element, $index);

        return $this;
    }

    public function replaceWith(Element $element): Element
    {
        $this->validateParent();

        $this->parent->replaceChild($this, $element);

        return $this;
    }

    protected function toHtml(): string
    {
        return '';
    }

    protected function toRtf(): string
    {
        return '';
    }

    protected function toText(): string
    {
        return '';
    }

    private function validateParent(): void
    {
        if ($this->parent === null) {
            throw new \BadMethodCallException(
                'element must belong to a parent element'
            );
        }
    }
}
