<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\{
    Element\Control\Word\Word as Element,
    Token\Control\Word as Token
};

class ControlWord
{
    private const WORD_NAMESPACE = 'Jstewmc\\Rtf\\Element\\Control\\Word\\';

    /**
     * An array of control word types (e.g., "FontFamily" or "CharacterSet"),
     * to use when searching for the control word class.
     */
    private array $types = [];

    public function __construct()
    {
        $this->setTypes();
    }

    /**
     * Sets this service's $types property by scanning the first-level
     * sub-directories in the control word directory.
     */
    private function setTypes(): void
    {
        $this->types = [];

        $pathnames = glob(__DIR__.'/../../Element/Control/Word/*', GLOB_ONLYDIR);

        foreach ($pathnames as $pathname) {
            $segments = explode('/', $pathname);
            $this->types[] = end($segments);
        }
    }

    public function __invoke(Token $token): Element
    {
        if ($this->isSpecific($token)) {
            $element = $this->parseSpecific($token);
        } else {
            $element = $this->parseGeneric($token);
        }

        $element->setIsSpaceDelimited($token->getIsSpaceDelimited());

        return $element;
    }

    private function isSpecific(Token $token): bool
    {
        return $this->hasClass($token->getWord());
    }

    private function hasClass(string $word): bool
    {
        if ($this->hasUntypedClass($word)) {
            return true;
        }

        foreach ($this->types as $type) {
            if ($this->hasTypedClass($type, $word)) {
                return true;
            }
        }

        return false;
    }

    private function hasUntypedClass(string $word): bool
    {
        return class_exists($this->getUntypedClassname($word));
    }

    private function getUntypedClassname(string $word): string
    {
        return self::WORD_NAMESPACE.ucfirst($word);
    }

    private function hasTypedClass(string $type, string $word): bool
    {
        return class_exists($this->getTypedClassname($type, $word));
    }

    private function getTypedClassname(string $type, string $word): string
    {
        return self::WORD_NAMESPACE."{$type}\\".ucfirst($word);
    }

    private function getClassname(string $word): string
    {
        if ($this->hasUntypedClass($word)) {
            return $this->getUntypedClassname($word);
        }

        foreach ($this->types as $type) {
            if ($this->hasTypedClass($type, $word)) {
                return $this->getTypedClassname($type, $word);
            }
        }
    }

    private function parseSpecific(Token $token): Element
    {
        $classname = $this->getClassname($token->getWord());

        if ($this->requiresParameter($classname)) {
            $element = new $classname($token->getParameter());
        } else {
            $element = new $classname();
            if ($token->hasParameter()) {
                $element->setParameter($token->getParameter());
            }
        }

        return $element;
    }

    /**
     * Returns true if the first argument to the constructor of $classname - the
     * control word's parameter - is required.
     */
    private function requiresParameter(string $classname): bool
    {
        $reflector = new \ReflectionClass($classname);

        $constructor = $reflector->getConstructor();

        $parameters = $constructor->getParameters();

        if (empty($parameters)) {
            return false;
        }

        $first = reset($parameters);

        return !$first->isOptional();
    }

    private function parseGeneric(Token $token): Element
    {
        $element = new Element($token->getWord());

        if ($token->hasParameter()) {
            $element->setParameter($token->getParameter());
        }

        return $element;
    }
}
