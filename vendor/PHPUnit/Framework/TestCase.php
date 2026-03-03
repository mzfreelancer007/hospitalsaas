<?php

declare(strict_types=1);

namespace PHPUnit\Framework;

abstract class TestCase
{
    protected function assertTrue(bool $condition, string $message = 'Failed asserting that condition is true.'): void
    {
        if (!$condition) {
            throw new \RuntimeException($message);
        }
    }
}
