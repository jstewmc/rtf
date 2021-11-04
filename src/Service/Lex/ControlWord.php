<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Stream,
    Token\Control\Word
};

class ControlWord
{
    public function __invoke(Stream $stream): Word
    {
        $this->validateStream($stream);

        $token = new Word($this->getWord($stream));

        if ($stream->isOnDigit() || $stream->isOnHyphen()) {
            $token->setParameter($this->getParameter($stream));
        }

        if (!$stream->isOnSpace()) {
            $token->setIsSpaceDelimited(false);
            $stream->previous();
        }

        return $token;
    }

    private function validateStream(Stream $stream): void
    {
        if (!$stream->isOnControlWord()) {
            throw new \InvalidArgumentException(
                'the stream must be on a control word'
            );
        }
    }

    private function getWord(Stream $stream): string
    {
        $word = '';

        $stream->next();

        while ($stream->isOnAlphabetic()) {
            $word .= $stream->current();
            $stream->next();
        }

        return $word;
    }

    private function getParameter(Stream $stream): int
    {
        // initialize to a string, before casting to int later
        $parameter = '';

        $isNegative = $stream->isOnHyphen();

        if ($isNegative) {
            $stream->next();
        }

        while ($stream->isOnDigit()) {
            $parameter .= $stream->current();
            $stream->next();
        }

        // evaluate the parameter's numeric value
        $parameter = +$parameter;

        // if the parameter is negative, negate it
        if ($isNegative) {
            $parameter = -$parameter;
        }

        return $parameter;
    }
}
