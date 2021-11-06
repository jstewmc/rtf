<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The apostrophe control symbol ("\'hh") is used to represent a non-ASCII
 * character from a Windows Code Page. The two digits "hh" are a hexadecimal
 * value for the given character in the given encoding.
 */
class Apostrophe extends Symbol
{
    private string $encoding = 'windows-1252';

    public function __construct(string $parameter)
    {
        parent::__construct('\'', $parameter);
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    protected function toHtml(): string
    {
        return $this->toText();
    }

    protected function toText(): string
    {
        return iconv($this->encoding, 'UTF-8', hex2bin($this->parameter));
    }
}
