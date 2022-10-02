<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FibersTest extends TestCase
{
    /**
     * Tests that when fibers.php is run, it outputs a series of integers from 1 to 10, in any order.
     */
    public function test(): void
    {
        ob_start();
        require __DIR__ . '/fibers.php';
        $lines = explode(PHP_EOL, rtrim(ob_get_flush()));

        self::assertEqualsCanonicalizing(range(1, 10), $lines);
    }
}
