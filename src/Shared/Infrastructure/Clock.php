<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\IClock;

class Clock implements IClock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
