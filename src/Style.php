<?php

namespace Jstewmc\Rtf;

/**
 * An element's style is the combination of its document-, section-, paragraph-,
 * and character-state.
 */
class Style
{
    private State\Character $character;

    private State\Document $document;

    private State\Paragraph $paragraph;

    private State\Section $section;

    public function __construct()
    {
        $this->document  = new State\Document();
        $this->section   = new State\Section();
        $this->paragraph = new State\Paragraph();
        $this->character = new State\Character();
    }

    public function getCharacter(): State\Character
    {
        return $this->character;
    }

    public function getDocument(): State\Document
    {
        return $this->document;
    }

    public function getParagraph(): State\Paragraph
    {
        return $this->paragraph;
    }

    public function getSection(): State\Section
    {
        return $this->section;
    }

    public function setCharacter(State\Character $character): self
    {
        $this->character = $character;

        return $this;
    }

    public function setDocument(State\Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function setParagraph(State\Paragraph $paragraph): self
    {
        $this->paragraph = $paragraph;

        return $this;
    }

    public function setSection(State\Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Clones this object deeply when PHP's `clone` is used
     *
     * PHP calls this magic method *after* it performs a shallow copy on all the
     * object's properties. Any properties that are references will remain
     * references.
     *
     * I'll clone the document, section, paragraph, and character states to
     * create a *deep* clone of this style.
     */
    public function __clone()
    {
        $this->document  = clone $this->document;
        $this->section   = clone $this->section;
        $this->paragraph = clone $this->paragraph;
        $this->character = clone $this->character;
    }

    /**
     * Merges two styles
     *
     * Every element has a cloned style object. However, the style will usually
     * change very litte element-to-element. It's a waste of memory to have
     * hundreds of identical objects.
     *
     * I'll merge this style object with $style. If a state is identical between
     * the two, I'll set this style's property to reference $style's property.
     */
    public function merge(Style $style): void
    {
        if ($style->getDocument() == $this->document) {
            $this->document = $style->getDocument();
        }

        if ($style->getSection() == $this->section) {
            $this->section = $style->getSection();
        }

        if ($style->getParagraph() == $this->paragraph) {
            $this->paragraph = $style->getParagraph();
        }

        if ($style->getCharacter() == $this->character) {
            $this->character = $style->getCharacter();
        }
    }
}
