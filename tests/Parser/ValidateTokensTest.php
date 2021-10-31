<?php

namespace Jstewmc\Rtf\Parser;

use Jstewmc\Rtf\Token;

class ValidateTokensTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeThrowsInvalidArgumentExceptionWhenRootIsMissing(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ValidateTokens())([new Token\Text('foo')]);
    }

    public function testInvokeThrowsInvalidArgumentExceptionWhenGroupsMismatched(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $tokens = [
            new Token\Group\Open(),
            new Token\Group\Close(),
            new Token\Group\Close()
        ];

        (new ValidateTokens())($tokens);
    }
}
