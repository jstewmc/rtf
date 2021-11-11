<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A control word token
 *
 * A control word is a specially-formatted command used to perform actions in an
 * RTF document such as: insert special characters, change destination, and set
 * paragraph- or character-formatting.
 *
 * A control word takes the following form:
 *
 *     \<word>[<delimiter>]
 *
 * The <word> is a string of alphabetic characters. RTF is case-sensitive, and
 * all RTF control words are lowercase. A control word must be shorter than 32
 * characters.
 *
 * The <delimiter> can be one of the following:
 *
 *     A space (" ")
 *         The space is considered part of the control word and does not appear
 *         in the document. However, any characters following the space,
 *         including additional spaces, will appear in the document.
 *
 *     A digit or hyphen ("-")
 *         A digit or hyphen indicates a numeric parameter follows. The subsequent
 *         digital sequence is then delimited by a space or any other character
 *         besides a letter or digit. The parameter can be a positive or negative
 *         number, generally between -32,767 and 32,767. However, readers should
 *         accept any arbitrary string of digits as a legal parameter.
 *
 *     Any character besides a letter or digit
 *         In this case, the delimiting character terminates the control word, but
 *         is not part of the control word.
 */
class Word extends Control
{
    private ?int $parameter = null;

    private string $word;

    public function getParameter(): ?int
    {
        return $this->parameter;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function setParameter(int $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function __construct(string $word)
    {
        $this->word = $word;
    }

    public function __toString(): string
    {
        $string = "\\{$this->word}{$this->parameter}";

        if ($this->isSpaceDelimited) {
            $string .= ' ';
        }

        return $string;
    }

    public function hasParameter(): bool
    {
        return $this->parameter !== null;
    }
}
