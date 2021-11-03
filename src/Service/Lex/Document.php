<?php

namespace Jstewmc\Rtf\Service\Lex;

use Jstewmc\Rtf\{
    Stream\Stream,
    Token
};

class Document
{
    private Stream $stream;

    private ControlSymbol $lexControlSymbol;

    private ControlWord $lexControlWord;

    private Text $lexText;

    public function __construct()
    {
        $this->lexControlSymbol = new ControlSymbol();
        $this->lexControlWord = new ControlWord();
        $this->lexText = new Text();
    }

    /**
     * @return  Token\Token[]
     */
    public function __invoke(Stream $stream): array
    {
        return $this->lexAll($stream);
    }

    /**
     * Lexes all tokens from the current stream
     *
     * @return  Token\Token[]
     */
    private function lexAll(Stream $stream): array
    {
        $tokens = [];

        while (false !== ($token = $this->lexOne($stream))) {
            $tokens[] = $token;
        }

        return $tokens;
    }

    /**
     * Lexes one token from the current stream (or returns false)
     *
     * I'll leave the stream's pointer on the first character after the token's
     * last character. For example, if the stream is "\foo bar", I'll leave the
     * stream's pointer on "b" (because the space is part of the control word).
     *
     * @return  Token\Token|false
     */
    private function lexOne(Stream $stream)
    {
        if ($stream->current() === false) {
            return false;
        }

        if ($stream->isOnGroupOpen()) {
            $token = $this->lexGroupOpen();
        } elseif ($stream->isOnGroupClose()) {
            $token = $this->lexGroupClose();
        } elseif ($stream->isOnLiteral()) {
            $token = ($this->lexText)($stream);
        } elseif ($stream->isOnImplicitParagraph()) {
            $token = $this->lexImplicitParagraph($stream);
        } elseif ($stream->isOnControlWord()) {
            $token = ($this->lexControlWord)($stream);
        } elseif ($stream->isOnControlSymbol()) {
            $token = ($this->lexControlSymbol)($stream);
        } elseif ($stream->isOnTab()) {
            $token = $this->lexTab();
        } elseif ($stream->isOnOther()) {
            $token = $this->lexOther($stream);
        } else {
            $token = ($this->lexText)($stream);
        }

        $stream->next();

        return $token;
    }

    private function lexGroupClose(): Token\Group\Close
    {
        return new Token\Group\Close();
    }

    private function lexGroupOpen(): Token\Group\Open
    {
        return new Token\Group\Open();
    }

    /**
     * Lexes the implicit paragraph - an escaped new-line or carriage-return
     * character - to a paragraph control word.
     */
    private function lexImplicitParagraph(Stream $stream): Token\Control\Word
    {
        // Consume the current ("\") and next characters ("\n").
        $stream->next();

        return new Token\Control\Word('par');
    }

    private function lexOther(Stream $stream): Token\Other
    {
        return new Token\Other($stream->current());
    }

    /**
     * Lexes the current tab character to a "\tab" control word.
     */
    private function lexTab(): Token\Control\Word
    {
        return new Token\Control\Word('tab');
    }
}
