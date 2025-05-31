<?php

declare(strict_types=1);

namespace App\Tests\Support\Mock\Shared\Domain;

use App\Shared\Domain\IClock;

class ClockMock implements IClock
{
    private \DateTimeImmutable $now;

    public function __construct(\DateTimeImmutable $now = null)
    {
        $this->now = $now ?? new \DateTimeImmutable();
    }

    public function now(): \DateTimeImmutable
    {
        return $this->now;
    }

    public function setNow(\DateTimeImmutable $now): void
    {
        $this->now = $now;
    }
}
