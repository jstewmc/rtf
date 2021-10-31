<?php

namespace Jstewmc\Rtf\Element;

use Jstewmc\Rtf\Style;

/**
 * A component of an RTF document, like an HTML tag or an XML node. Elements
 * can be groups, text, control words, and control symbols.
 */
class Element
{
    protected ?Group $parent = null;

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

    /**
     * Returns this element's index in its parent children
     *
     * Warning! This method may return a boolean false, but it may also return an
     * integer value that evaluates to false. Use the strict comparison operator,
     * "===" when testing the return value of this method.
     *
     * @return  int|false
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     * @since  0.1.0
     */
    public function getIndex()
    {
        $index = false;

        // if this element has a parent
        if (! empty($this->parent)) {
            $index = $this->parent->getChildIndex($this);
            // if we didn't find the child, something is wrong
            if ($index === false) {
                throw new \BadMethodCallException(
                    __METHOD__."() expects this element to be a child of its parent"
                );
            }
        } else {
            throw new \BadMethodCallException(
                __METHOD__."() expects this element to have a parent element"
            );
        }

        return $index;
    }

    /**
     * Returns this element's next sibling or null if no sibling exists
     *
     * @return  Jstewmc\Rtf\Element\Element|null
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     * @since  0.1.0
     */
    public function getNextSibling()
    {
        $next = null;

        // if this element has an index
        if (false !== ($index = $this->getIndex())) {
            // if this element has a next sibling
            if ($this->parent->hasChild($index + 1)) {
                $next = $this->parent->getChild($index + 1);
            }
        }

        return $next;
    }

    /**
     * Returns this element's next text element or null if no next text element
     *     exists
     *
     * @return  Jstewmc\Rtf\Element\Text|null
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     */
    public function getNextText()
    {
        $text = null;

        // get the element's next sibling element
        $next = $this->getNextSibling();

        // while the next sibling element exists and is not a text element
        while ($next !== null && ! $next instanceof Text) {
            $next = $next->getNextSibling();
        }

        // if a next text element exists
        if ($next !== null && $next instanceof Text) {
            $text = $next;
        }

        return $text;
    }

    /**
     * Returns this element's previous sibling or null if no sibling exists
     *
     * @return  Jstewmc\Rtf\Element\Element|null
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     * @since  0.1.0
     */
    public function getPreviousSibling()
    {
        $previous = null;

        // if this element has an index
        if (false !== ($index = $this->getIndex())) {
            // if this element has a previous sibling
            if ($this->parent->hasChild($index - 1)) {
                $previous = $this->parent->getChild($index - 1);
            }
        }

        return $previous;
    }

    /**
     * Returns this element's previous text element or null if not previous text
     *     element exists
     *
     * @return  Jstewmc\Rtf\Element\Text|null
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     */
    public function getPreviousText()
    {
        $text = null;

        // get the element's preivous sibling element
        $previous = $this->getPreviousSibling();

        // while the previous sibling element exists and is not a text element
        while ($previous !== null && ! $previous instanceof Text) {
            $previous = $previous->getPreviousSibling();
        }

        // if a previous text element exists
        if ($previous !== null && $previous instanceof Text) {
            $text = $previous;
        }

        return $text;
    }

    /**
     * Returns the element as a string in $format
     *
     * @param  string  $format  the desired format (possible values are 'rtf',
     *     'html', and 'text') (optional; if omitted, defaults to 'rtf')
     * @return  string
     * @throws  InvalidArgumentException  if $format is not a string
     * @throws  InvalidArgumentException  if $format is not 'rtf', 'html', or 'text'
     * @since   0.1.0
     */
    public function format($format = 'rtf')
    {
        $string = '';

        // if $format is a string
        if (is_string($format)) {
            // switch on the lower-cased format
            switch (strtolower($format)) {
                case 'html':
                    $string = $this->toHtml();
                    break;

                case 'rtf':
                    $string = $this->toRtf();
                    break;

                case 'text':
                    $string = $this->toText();
                    break;

                default:
                    throw new \InvalidArgumentException(
                        __METHOD__."() expects parameter one, format, to be 'rtf', 'html', or 'text'"
                    );
            }
        } else {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, format, to be a string"
            );
        }

        return $string;
    }

    /**
     * Inserts this element after $element
     *
     * @param  Jstewmc\Rtf\Element  $element  the element to insert after
     * @return  self
     * @throws  BadMethodCallException  if $element doesn't have a parent
     * @throws  BadMethodCallException  if $element's parent doesn't have children
     * @throws  BadMethodCallException  if $element is not a child of its parent
     * @since  0.1.0
     */
    public function insertAfter(Element $element)
    {
        // if $element has an index
        if (false !== ($index = $element->getIndex())) {
            $element->getParent()->insertChild($this, $index + 1);
        }

        return $this;
    }

    /**
     * Inserts this element before $element
     *
     * @param  Jstewmc\Rtf\Element  $element  the element to insert before
     * @return  self
     * @throws  BadMethodCallException  if $element doesn't have a parent
     * @throws  BadMethodCallException  if $element's parent doesn't have children
     * @throws  BadMethodCallException  if $element is not a child of its parent
     * @since  0.1.0
     */
    public function insertBefore(Element $element)
    {
        // if $element has an index
        if (false !== ($index = $element->getIndex())) {
            $element->getParent()->insertChild($this, $index);
        }

        return $this;
    }

    /**
     * Returns true if this element is the first child
     *
     * @return  bool
     * @throws  BadMethodCallException  if this element doesn't have a parent
     * @throws  BadMethodCallException  if this element's parent doesn't have children
     * @throws  BadMethodCallException  if this element is not a child of its parent
     * @since  0.1.0
     */
    public function isFirstChild()
    {
        return $this->getIndex() === 0;
    }

    /**
     * Returns true if this element is the last child
     *
     * @return  bool
     * @throws  BadMethodCallException  if this element doesn't have a parent
     * @throws  BadMethodCallException  if this element's parent doesn't have children
     * @throws  BadMethodCallException  if this element is not a child of its parent
     * @since  0.1.0
     */
    public function isLastChild()
    {
        return $this->getIndex() === $this->parent->getLength() - 1;
    }

    /**
     * Prepends the element to $group
     *
     * @param  Jstewmc\Rtf\Element\Group  $group  the group to prepend to
     * @return  self
     * @since  0.1.0
     */
    public function prependTo(Group $group)
    {
        $group->prependChild($this);

        return $this;
    }

    /**
     * Inserts an element after this element
     *
     * @param  Jstewmc\Rtf\Element\Element  $element  the element to insert
     * @return  self
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     * @since  0.1.0
     */
    public function putNextSibling(Element $element)
    {
        if (false !== ($index = $this->getIndex())) {
            $this->parent->insertChild($element, $index + 1);
        }

        return $this;
    }

    /**
     * Inserts $element before this element
     *
     * @param  Jstewmc\Rtf\Element\Element  $element  the element to insert
     * @return  self
     * @throws  BadMethodCallException  if the element doesn't have a parent
     * @throws  BadMethodCallException  if the element's parent doesn't have children
     * @throws  BadMethodCallException  if the element is not a child of its parent
     * @since  0.1.0
     */
    public function putPreviousSibling(Element $element)
    {
        if (false !== ($index = $this->getIndex())) {
            $this->parent->insertChild($element, $index);
        }

        return $this;
    }

    /**
     * Replaces this element with $element (and returns this element)
     *
     * @param  Jstewmc\Rtf\Element  $element  the replacement element
     * @return  Jstewmc\Rtf\Element
     * @throws  BadMethodCallException  if this element doesn't have a parent
     * @since  0.1.0
     */
    public function replaceWith(Element $element)
    {
        // if the element has a parent
        if (! empty($this->parent)) {
            $this->parent->replaceChild($this, $element);
        } else {
            throw new \BadMethodCallException(
                __METHOD__."() expects this element to have a parent element"
            );
        }

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
}
