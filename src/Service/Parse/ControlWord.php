<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{
    Element\Control\Word\Word as Element,
    Token\Control\Word as Token
};

class ControlWord
{
    private const WORDS_WITH_PARAMETER = ['rtf', 'ansicpg'];

    public function __invoke(Token $token): Element
    {
        $word = $token->getWord();

        if ($this->hasClass($word)) {
            $element = $this->parseSpecific($token);
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

    private function parseSpecific(Token $token): Element
    {
        $classname = $this->getClassname($token->getWord());

        if ($this->hasParameter($token->getWord())) {
            $element = new $classname($token->getParameter());
        } else {
            $element = new $classname();
        }

        return $element;
    }

    private function hasParameter(string $word): bool
    {
        return in_array($word, self::WORDS_WITH_PARAMETER);
    }

    private function parseGeneric(string $word): Element
    {
        return new Element($word);
    }
}
