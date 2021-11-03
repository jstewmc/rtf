<?php

namespace Jstewmc\Rtf;

class Document
{
    private Lexer\Document $lex;

    private Service\Write $writer;

    private Parser\Document $parser;

    private Service\Render $render;

    private Element\Group $root;

    public function getRoot(): ?Element\Group
    {
        return $this->root;
    }

    public function __construct(string $source)
    {
        $this->root = new Element\Group();

        $this->lex = new Lexer\Document();
        $this->parser = new Parser\Document();
        $this->writer = new Service\Write();
        $this->render = new Service\Render();

        is_readable($source) ? $this->load($source) : $this->read($source);
    }

    private function load(string $pathname): void
    {
        $this->create(new Stream\File($pathname));
    }

    private function read(string $string): void
    {
        $this->create(new Stream\Text($string));
    }

    private function create(Stream\Stream $stream): void
    {
        $tokens = ($this->lex)($stream);

        if (empty($tokens)) {
            return;
        }

        $group = ($this->parser)($tokens);

        $this->root = ($this->render)($group);
    }

    public function __toString()
    {
        return $this->write();
    }

    public function write(string $format = 'rtf'): string
    {
        return ($this->writer)($this->root, $format);
    }

    public function save(string $pathname, ?string $format = null): void
    {
        $this->validateFormat($format);

        if ($format === null) {
            $format = $this->detectFormat($pathname);
        }

        file_put_contents($pathname, $this->write($format));
    }

    private function validateFormat(?string $format): void
    {
        if ($format === null) {
            return;
        }

        if (!in_array($format, ['htm', 'html', 'rtf', 'text'])) {
            throw new \InvalidArgumentException(
                "format must be 'html', 'rtf', 'text', or null"
            );
        }
    }

    private function detectFormat(string $pathname): string
    {
        $period = strrpos($pathname, '.');

        $extension = substr($pathname, $period + 1);

        if ($extension === 'htm' || $extension === 'html') {
            $format = 'html';
        } elseif ($extension === 'rtf') {
            $format = 'rtf';
        } elseif ($extension === 'txt') {
            $format = 'text';
        } else {
            throw new \InvalidArgumentException(
                'format could not be detected from pathname'
            );
        }

        return $format;
    }
}
