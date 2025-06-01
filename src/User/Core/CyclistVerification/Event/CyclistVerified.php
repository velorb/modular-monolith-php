<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification\Event;

use App\Shared\Domain\DomainEvent;
use App\Shared\Domain\User\UserId;
use App\User\Core\CyclistVerification\CyclistVerificationProcessId;

readonly class CyclistVerified extends DomainEvent
{
    public function __construct(
        CyclistVerificationProcessId $aggregateId,
        \DateTimeImmutable $occurredAt,
        public UserId $userId
    ) {
        parent::__construct($aggregateId, $occurredAt);
    }
}
