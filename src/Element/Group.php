<?php

namespace Jstewmc\Rtf\Element;

class Group extends Element
{
    /**
     * An array of this group's child elements
     */
    protected array $children = [];

    /**
     * A flag indicating whether or not this group has been rendered (if true,
     * inserting and deleting elements will cause a re-render)
     */
    protected bool $isRendered = false;

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getIsRendered(): bool
    {
        return $this->isRendered;
    }

    public function setChildren(array $children): self
    {
        foreach ($children as $child) {
            $child->setParent($this);
        }

        $this->children = $children;

        return $this;
    }

    public function setIsRendered(bool $isRendered): self
    {
        $this->isRendered = $isRendered;

        return $this;
    }

    public function appendChild(Element $element): self
    {
        $this->beforeInsert($element);

        array_push($this->children, $element);

        $this->afterInsert();

        return $this;
    }

    private function beforeInsert(Element $element): void
    {
        $element->setParent($this);
    }

    private function afterInsert(): void
    {
        if ($this->isRendered) {
            $this->render();
        }
    }

    public function getChild(int $index): Element
    {
        if (!array_key_exists($index, $this->children)) {
            throw new \OutOfBoundsException(
                "index, $index, must be an existing array key"
            );
        }

        return $this->children[$index];
    }

    /**
     * Returns an array of control words with $word and, optionally, with
     * matching $parameter
     *
     * @param  int|null|false  $parameter  the control word's integer parameter,
     *     null for any parameter, or false for no parameter (optional; if omitted,
     *     defaults to null)
     */
    public function getControlWords(string $word, $parameter = null): array
    {
        if ($parameter !== null && $parameter !== false && !is_int($parameter)) {
            throw new \InvalidArgumentException(
                'parameter must be false, null, or int'
            );
        }

        $words = [];
        foreach ($this->children as $child) {
            if ($child instanceof Group) {
                $words = array_merge(
                    $words,
                    $child->getControlWords($word, $parameter)
                );
            } elseif ($child instanceof Control\Word\Word &&
                $child->getWord() == $word &&
                $this->isParameterMatch($parameter, $child)
            ) {
                $words[] = $child;
            }
        }

        return $words;
    }

    private function isParameterMatch($parameter, Element $child): bool
    {
        return $parameter === null ||
            ($parameter === false && $child->getParameter() === null) ||
            $child->getParameter() == $parameter;
    }

    /**
     * Returns an array of control symbols with $symbol and, optionally, with
     *     $parameter
     *
     * @param  string|null|false  $parameter  the symbol's string parameter; null,
     *     any parameter; or, false, no parameter (optional; if omitted, defaults to
     *     null)
     */
    public function getControlSymbols(string $symbol, $parameter = null): array
    {
        $symbols = [];

        if ($parameter !== null && $parameter !== false && !is_string($parameter)) {
            throw new \InvalidArgumentException(
                'parameter must be false, null, or string'
            );
        }

        foreach ($this->children as $child) {
            if ($child instanceof Group) {
                $symbols = array_merge(
                    $symbols,
                    $child->getControlSymbols($symbol, $parameter)
                );
            } elseif ($child instanceof Control\Symbol\Symbol &&
                $child->getSymbol() == $symbol &&
                $this->isParameterMatch($parameter, $child)
            ) {
                $symbols[] = $child;
            }
        }

        return $symbols;
    }


    /**
     * Returns the child's index in this group's children (if it exists)
     *
     * Warning! This method may return a boolean false, but it may also return an
     * integer value that evaluates to false. Use the strict comparison operator,
     * "===" when testing the return value of this method.
     *
     * @param  Jstewm\Rtf\Element\Element  $element  the element to find
     * @return  int|false
     */
    public function getChildIndex(Element $element)
    {
        foreach ($this->children as $k => $child) {
            if ($child === $element) {
                return $k;
            }
        }

        return false;
    }

    public function getFirstChild(): ?Element
    {
        return count($this->children) > 0 ? reset($this->children) : null;
    }

    public function getLastChild(): ?Element
    {
        return count($this->children) > 0 ? end($this->children) : null;
    }

    public function getLength(): int
    {
        return count($this->children);
    }

    /**
     * Returns true if the group has the child
     *
     * @example  the element exists at any index
     *   $this->hasChild($element);
     *
     * @example  the element exists at the given index
     *   $this->hasChild($element, 1);
     *
     * @example  any element at the given index
     *   $this->hasChild(1);
     */
    public function hasChild($one, ?int $two = null): bool
    {
        if (!($one instanceof Element) && !is_int($one)) {
            throw new \InvalidArgumentException(
                'argument one must be an element or int'
            );
        }

        if ($one instanceof Element && $two === null) {
            // true if *the* element exists at *any* index
            $hasChild = $this->getChildIndex($one) !== false;
        } elseif ($one instanceof Element) {
            // true if *the* element exists at *the* index
            $hasChild = $this->getChildIndex($one) === $two;
        } elseif ($two === null) {
            // true if *any* element exists at *the* index
            $hasChild = array_key_exists($one, $this->children)
                && !empty($this->children[$one]);
        }

        return $hasChild;
    }

    /**
     * Inserts $element at $index
     *
     * @param  int  $index  the child's index (a valid array key; one higher
     *   than the highest key; or, zero)
     */
    public function insertChild(Element $element, int $index): self
    {
        if (array_key_exists($index, $this->children)) {
            $this->beforeInsert($element);
            array_splice($this->children, $index, 0, [$element]);
            $this->afterInsert();
        } elseif ($index === count($this->children)) {
            $this->appendChild($element);
        } elseif ($index === 0) {
            $this->prependChild($element);
        } else {
            throw new \OutOfBoundsException(
                'index must be a valid key, zero, or length plus one'
            );
        }

        return $this;
    }

    public function isDestination(): bool
    {
        return $this->getFirstChild() instanceof Control\Symbol\Asterisk;
    }

    public function render(): void
    {
        $this->beforeRender();

        foreach ($this->children as $k => $child) {
            // get the child's (starting) style...
            //
            // if this child is the first-child, it inherits the group's style;
            //   otherwise, it inherits the previous child's (ending) style
            if ($k == 0) {
                $style = $this->style;
            } else {
                $previous = $this->children[$k - 1];
                $style = $previous->getStyle();
            }

            // set the child's style...
            //
            // clone the style to create a distinct copy of the child's state;
            //   otherwise, changes to the child's state will affect the
            //   group's state, and the group's (ending) state will be the last
            //   child's (ending) state
            $child->setStyle(clone $style);

            if ($child instanceof Group) {
                $child->render();
            } elseif ($child instanceof Control\Control) {
                $child->run();
            }

            // finally, merge the (ending) state of the current child with the
            //   (ending) state of the previous sibling (to save memory)
            $child->getStyle()->merge($style);
        }

        $this->afterRender();
    }

    private function beforeRender(): void
    {
        $this->isRendered = false;
    }

    private function afterRender(): void
    {
        $this->isRendered = true;
    }

    public function prependChild(Element $element): self
    {
        $this->beforeInsert($element);

        array_unshift($this->children, $element);

        $this->afterInsert();

        return $this;
    }

    /**
     * Removes a child from the parent (and returns it)
     *
     * @param  Element|int  $arg  the element or int index to remove
     */
    public function removeChild($arg): Element
    {
        if (!($arg instanceof Element) && !is_int($arg)) {
            throw new \InvalidArgumentException(
                'argument must be an integer or element'
            );
        }

        $index = is_int($arg) ? $arg : $this->getChildIndex($arg);

        if ($index === false || !array_key_exists($index, $this->children)) {
            throw new \OutOfBoundsException(
                'argument must be a valid child element or key'
            );
        }

        $this->beforeDelete();

        $slice = array_splice($this->children, $index, 1);

        $removed = reset($slice);

        $this->afterDelete($removed);

        return $removed;
    }

    /**
     * Replaces the the $old with $new (and returns replaced element)
     *
     * @param  Element|int  $old  the element or index to be replace
     */
    public function replaceChild($old, Element $new): Element
    {
        if (!is_int($old) && !($old instanceof Element)) {
            throw new \InvalidArgumentException(
                'argument one must be an index or element'
            );
        }

        $index = is_int($old) ? $old : $this->getChildIndex($old);

        if ($index === false || !array_key_exists($index, $this->children)) {
            throw new \OutOfBoundsException(
                'argument one must be a valid key or child element'
            );
        }

        $this->beforeInsert($new);

        $slice = array_splice($this->children, $index, 1, [$new]);

        $replaced = reset($slice);

        $this->afterDelete($replaced);

        return $replaced;
    }

    private function afterDelete(Element $element): void
    {
        $element->setParent(null);

        if ($this->isRendered) {
            $this->render();
        }
    }

    private function beforeDelete(): void
    {
        return;
    }

    public function toHtml(): string
    {
        if ($this->isDestination()) {
            return '';
        }

        $html = '';

        // set the first element's "old" style to the group's style
        $oldStyle = $this->style;

        // define a flag indicating whether or not this group is the root group
        //
        // setting this flag here feel a little hackish!
        // however, the first element in the first group is different than the first
        //     element in any other group
        $isFirstGroup = empty($this->parent);

        // a flag indicating whether or not the element is the first "textual" element
        //     in the group (i.e., control word with a special symbol, an actual text
        //     element, etc)
        $isFirstTextualElement = true;

        // loop through the group's children
        foreach ($this->children as $child) {
            // if the child is a textual element
            $string = $child->format('html');
            if (! empty($string)) {
                // get the child's style
                $newStyle = $child->getStyle();
                // if the child is the first textual element in the first (aka, "root") group
                if ($isFirstGroup && $isFirstTextualElement) {
                    // open the document's first section, paragraph, and character tags
                    $html .= '<section style="'.$newStyle->getSection()->format('css').'">'
                         . '<p style="'.$newStyle->getParagraph()->format('css').'">'
                         . '<span style="'.$newStyle->getCharacter()->format('css').'">';
                    // set the flag to false
                    $isFirstTextualElement = false;
                } else {
                    // otherwise, the child is not the first textual element in the root group
                    //    and we only close and open the section, paragraph, and character tags
                    //    if the style has changed between elements
                    //
                    // keep in mind, a section takes precedence over a paragraph and a character;
                    //     a paragraph takes precedence over a character; so on and so forth
                    if ($oldStyle->getSection() != $newStyle->getSection()) {
                        $html .= '</span></p></section>'
                            . '<section style="'.$newStyle->getSection()->format('css').'">'
                            . '<p style="'.$newStyle->getParagraph()->format('css').'">'
                            . '<span style="'.$newStyle->getCharacter()->format('css').'">';
                    } elseif ($oldStyle->getParagraph() != $newStyle->getParagraph()) {
                        $html .= '</span></p>'
                            . '<p style="'.$newStyle->getParagraph()->format('css').'">'
                            . '<span style="'.$newStyle->getCharacter()->format('css').'">';
                    } elseif ($oldStyle->getCharacter() != $newStyle->getCharacter()) {
                        $html .= '</span>'
                            . '<span style="'.$newStyle->getCharacter()->format('css').'">';
                    }
                }

                // append the html string
                $html .= $string;

                // set the "old" style to the current element's style for the next iteration
                $oldStyle = $newStyle;
            }
        }

        return $html;
    }

    public function toRtf(): string
    {
        $rtf = '{';

        foreach ($this->children as $child) {
            $rtf .= $child->format('rtf');
        }

        $rtf .= '}';

        return $rtf;
    }

    public function toText(): string
    {
        $text = '';

        if (! $this->isDestination()) {
            foreach ($this->children as $child) {
                $text .= $child->format('text');
            }
        }

        return $text;
    }
}
