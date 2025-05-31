<?php

declare(strict_types=1);

namespace App\Tests\Support;

use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    protected function getClock(?string $now = null): ClockMock
    {
        return new ClockMock(new \DateTimeImmutable($now ?? 'now'));
    }
}
