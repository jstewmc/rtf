<?php

namespace Jstewmc\Rtf\Stream;

trait Lexable
{
    public function isOnLiteral(): bool
    {
        return $this->isOn(['\\\\', '\\{', '\\}']);
    }

    public function isOnImplicitParagraph(): bool
    {
        return $this->isOn(["\\\n", "\\\r"]);
    }

    public function isOnControlWord(): bool
    {
        return $this->isOnRegex('/\\\[a-z]/', 2);
    }

    public function isOnControlSymbol(): bool
    {
        return $this->isOnRegex('/\\\[^a-z]/', 2);
    }

    public function isOnGroupOpen(): bool
    {
        return $this->isOn('{');
    }

    public function isOnGroupClose(): bool
    {
        return $this->isOn('}');
    }

    public function isOnTab(): bool
    {
        return $this->isOn("\t");
    }

    public function isOnOther(): bool
    {
        return $this->isOn(["\n", "\r", "\f", "\0"]);
    }

    public function isOnBackslash(): bool
    {
        return $this->isOn('\\');
    }

    public function isOnDigit(): bool
    {
        return $this->isOnRegex('/[0-9]/');
    }

    public function isOnHyphen(): bool
    {
        return $this->isOn('-');
    }

    public function isOnAlphabetic(): bool
    {
        return $this->isOnRegex('/[a-z]/');
    }

    public function isOnSpace(): bool
    {
        return $this->isOn(' ');
    }

    public function isOnApostrophe(): bool
    {
        return $this->isOn('\'');
    }
}
