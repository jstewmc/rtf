<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Stream,
    Token\Control\Symbol
};

class ControlSymbol
{
    public function __invoke(Stream $stream): Symbol
    {
        $this->validateStream($stream);

        $token = new Symbol($this->getSymbol($stream));

        if ($stream->isOnApostrophe()) {
            $token->setParameter($this->getParameter($stream));
        }

        $stream->next();

        if (!$stream->isOnSpace()) {
            $token->setIsSpaceDelimited(false);
            $stream->previous();
        }

        return $token;
    }

    private function validateStream(Stream $stream): void
    {
        if (!$stream->isOnControlSymbol()) {
            throw new \InvalidArgumentException(
                'the stream must be on a control symbol'
            );
        }
    }

    private function getSymbol(Stream $stream): string
    {
        return $stream->next();
    }

    private function getParameter(Stream $stream): string
    {
        return "{$stream->next()}{$stream->next()}";
    }
}
