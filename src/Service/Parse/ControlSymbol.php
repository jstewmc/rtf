<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{
    Element\Control\Symbol\Symbol as Element,
    Token\Control\Symbol as Token
};

class ControlSymbol
{
    private const SYMBOL_NAMES = [
        '\'' => 'apostrophe',
        '*'  => 'asterisk',
        '-'  => 'hyphen',
        '~'  => 'tilde',
        '_'  => 'underscore'
    ];

    public function __invoke(Token $token): Element
    {
        if ($this->isSpecific($token->getSymbol())) {
            $symbol = $this->parseSpecific($token);
        } else {
            $symbol = $this->parseGeneric($token);
        }

        $symbol->setIsSpaceDelimited($token->getIsSpaceDelimited());

        return $symbol;
    }

    private function isSpecific(string $symbol): bool
    {
        return $this->hasName($symbol) && $this->hasClass($symbol);
    }

    private function hasName(string $symbol): bool
    {
        return array_key_exists($symbol, self::SYMBOL_NAMES);
    }

    private function hasClass(string $symbol): bool
    {
        return class_exists($this->getClassname($symbol));
    }

    private function getClassname(string $symbol): string
    {
        return "Jstewmc\\Rtf\\Element\\Control\\Symbol\\{$this->getName($symbol)}";
    }

    private function getName(string $symbol): string
    {
        return ucfirst(self::SYMBOL_NAMES[$symbol]);
    }

    private function parseGeneric(Token $token): Element
    {
        return new Element($token->getSymbol());
    }

    private function parseSpecific(Token $token): Element
    {
        $classname = $this->getClassname($token->getSymbol());

        if ($token->getSymbol() === '\'') {
            $element = new $classname($token->getParameter());
        } else {
            $element = new $classname();
        }

        return $element;
    }
}
