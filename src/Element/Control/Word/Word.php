<?php

namespace Jstewmc\Rtf\Element\Control\Word;

class Word extends \Jstewmc\Rtf\Element\Control\Control
{
    /* !Protected properties */

    /**
     * A flag indicating whether or not the control word should be preceeded by
     * the "ignored" control symbol (defaults to false)
     */
    protected bool $isIgnored = false;

    /**
     * The parameters of certain control words (such as bold and italic) have
     * two states: missing or non-zero values turns _on_ the control word, and
     * a zero value turns _off_ the control world
     */
    protected ?int $parameter = null;

    /**
     * The control word's word (defaults to classname)
     */
    protected string $word;

    public function getIsIgnored(): bool
    {
        return $this->isIgnored;
    }

    public function getParameter(): ?int
    {
        return $this->parameter;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function setIsIgnored(bool $isIgnored): self
    {
        $this->isIgnored = $isIgnored;

        return $this;
    }

    public function setParameter(?int $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }


    public function __construct($parameter = null)
    {
        $this->word = $this->getDefaultWord();

        if ($parameter !== null) {
            $this->parameter = $parameter;
        }
    }

    private function getDefaultWord(): string
    {
        $classname = get_class($this);

        $segments = explode('\\', $classname);

        $filename = strtolower(end($segments));

        return $filename;
    }

    protected function toRtf(): string
    {
        $rtf = '';

        // if a word exists
        if ($this->word) {
            // if the word is ignored
            if ($this->isIgnored) {
                // prepend the ignored control symbol
                $rtf = '\\*';
            }
            // append the word and its parameter
            $rtf .= "\\{$this->word}{$this->parameter}";
            // if the word is space-delimited, append the space
            if ($this->isSpaceDelimited) {
                $rtf .= ' ';
            }
        }

        return $rtf;
    }
}
