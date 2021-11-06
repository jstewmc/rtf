<?php

namespace Jstewmc\Rtf;

class Document
{
    private Service\Lex\Document $lex;

    private Service\Write $output;

    private Service\Parse\Document $parse;

    private Service\Render $render;

    private Service\Encode $encode;

    private Element\Group $root;

    public function getRoot(): ?Element\Group
    {
        return $this->root;
    }

    public function __construct(string $source)
    {
        $this->root = new Element\Group();

        $this->lex    = new Service\Lex\Document();
        $this->parse  = new Service\Parse\Document();
        $this->encode = new Service\Encode();
        $this->render = new Service\Render();
        $this->output = new Service\Write();

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

        $group = ($this->parse)($tokens);

        ($this->encode)($group);

        $this->root = ($this->render)($group);
    }

    public function __toString()
    {
        return $this->write();
    }

    public function write(string $format = 'rtf'): string
    {
        return ($this->output)($this->root, $format);
    }

    public function save(string $pathname, ?string $format = null): void
    {
        $this->validateFormat($format);

        $format = $format ?: $format = $this->detectFormat($pathname);

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
