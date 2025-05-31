<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Id\Ulid;

abstract readonly class DomainEvent
{
    public function __construct(
        public Ulid $aggregateId,
        public \DateTimeImmutable $occurredOn,
    ) {
    }
}
