<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Token;

class SanitizeTokensTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsTokensWhenTokensDoNotOccur(): void
    {
        $tokens = [
            new Token\Group\Open(),
            new Token\Group\Close()
        ];

        $this->assertEquals($tokens, (new SanitizeTokens())($tokens));
    }

    public function testInvokeReturnsTokensWhenTokensDoOccur(): void
    {
        $input = [
            new Token\Text('foo'),
            new Token\Group\Open(),
            new Token\Group\Close()
        ];

        $output = array_slice($input, 1);

        $this->assertEquals($output, (new SanitizeTokens())($input));
    }
}
