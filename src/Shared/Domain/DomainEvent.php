<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Id\Ulid;
use App\Shared\Domain\Id\Uuid;

abstract readonly class DomainEvent
{
    public function __construct(
        public Ulid|Uuid $aggregateId,
        public \DateTimeImmutable $occurredAt,
    ) {
    }
}
