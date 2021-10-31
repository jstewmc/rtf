<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\{
    Element\Control\Word\Word as Element,
    Token\Control\Word as Token
};

class ControlWord
{
    public function __invoke(Token $token): Element
    {
        $word = $token->getWord();

        if ($this->hasClass($word)) {
            $element = $this->parseSpecific($word);
        } else {
            $element = $this->parseGeneric($word);
        }

        $element->setParameter($token->getParameter());
        $element->setIsSpaceDelimited($token->getIsSpaceDelimited());

        return $element;
    }

    private function hasClass(string $word): bool
    {
        return class_exists($this->getClassname($word));
    }

    private function getClassname(string $word): string
    {
        return 'Jstewmc\\Rtf\\Element\\Control\\Word\\'.ucfirst($word);
    }

    private function parseSpecific(string $word): Element
    {
        $classname = $this->getClassname($word);

        return new $classname();
    }

    private function parseGeneric(string $word): Element
    {
        return (new Element())->setWord($word);
    }
}
