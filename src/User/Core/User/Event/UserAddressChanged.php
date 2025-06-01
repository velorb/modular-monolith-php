<?php

declare(strict_types=1);

namespace App\User\Core\User\Event;

use App\Shared\Domain\Address;
use App\Shared\Domain\DomainEvent;
use App\Shared\Domain\User\UserId;

readonly class UserAddressChanged extends DomainEvent
{
    public function __construct(
        UserId $aggregateId,
        \DateTimeImmutable $occurredAt,
        public Address $address,
    ) {
        parent::__construct($aggregateId, $occurredAt);
    }
}
