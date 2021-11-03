<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Token\Group;

/**
 * Removes tokens that occur before the root group-open token, as dictated by
 * the specification.
 */
class SanitizeTokens
{
    public function __invoke(array $tokens): array
    {
        if ($this->startsWithRoot($tokens)) {
            return $tokens;
        }

        return $this->startWithRoot($tokens);
    }

    private function startsWithRoot(array $tokens): bool
    {
        return reset($tokens) instanceof Group\Open;
    }

    private function startWithRoot(array $tokens): array
    {
        return array_slice($tokens, $this->findRoot($tokens));
    }

    private function findRoot(array $tokens): int
    {
        foreach ($tokens as $key => $token) {
            if ($token instanceof Group\Open) {
                return $key;
            }
        }
    }
}
