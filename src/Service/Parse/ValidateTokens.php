<?php

namespace Jstewmc\Rtf\Service\Parse;

use Jstewmc\Rtf\Token\Group;

class ValidateTokens
{
    public function __invoke(array $tokens): void
    {
        if (!$this->hasTokens($tokens)) {
            throw new \InvalidArgumentException(
                'tokens must not be empty'
            );
        }

        if (!$this->hasRoot($tokens)) {
            throw new \InvalidArgumentException(
                'tokens must have at least one group'
            );
        }

        if (!$this->hasSymmetry($tokens)) {
            throw new \InvalidArgumentException(
                'tokens must have symmetric group-open and group-close tokens'
            );
        }
    }

    private function hasTokens(array $tokens): bool
    {
        return !empty($tokens);
    }

    private function hasRoot(array $tokens): bool
    {
        foreach ($tokens as $token) {
            if ($token instanceof Group\Open) {
                return true;
            }
        }

        return false;
    }

    private function hasSymmetry(array $tokens): bool
    {
        return $this->countGroupOpens($tokens) === $this->countGroupCloses($tokens);
    }

    private function countGroupCloses(array $tokens): int
    {
        return array_reduce($tokens, function ($carry, $item) {
            return $carry += $item instanceof Group\Close;
        }, 0);
    }

    private function countGroupOpens(array $tokens): int
    {
        return array_reduce($tokens, function ($carry, $item) {
            return $carry += $item instanceof Group\Open;
        }, 0);
    }
}
