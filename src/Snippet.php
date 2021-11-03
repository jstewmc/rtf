<?php

namespace Jstewmc\Rtf;

class Snippet extends Element\Group
{
    public function __construct(string $source)
    {
        $this->read($source);
    }

    public function __toString(): string
    {
        return $this->write();
    }

    public function write(string $format = 'rtf'): string
    {
        // get the snippet (which is posing as a group) as a string
        $string = (new Service\Write())($this, $format);

        // if the format is "rtf", remove the group-open and group-close we added
        if ($format === 'rtf') {
            $string = substr($string, 1, -1);
        }

        return $string;
    }

    private function read(string $string): void
    {
        // fake the snippet as a "root" group
        $string = '{'.$string.'}';

        // instantiate the string's chunker and stream
        $stream = new Stream\Text($string);

        // lex the stream
        $tokens = (new Lexer\Document())($stream);

        // parse and render the tokens
        $group = (new Service\Render())((new Parser\Document())($tokens));

        // set the snippet's properties from the group
        $this->parent     = null;
        $this->children   = $group->getChildren();
        $this->style      = $group->getStyle();
        $this->isRendered = true;
    }
}
