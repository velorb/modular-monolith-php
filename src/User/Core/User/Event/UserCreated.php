<?php

declare(strict_types=1);

namespace App\User\Core\User\Event;

use App\Shared\Domain\DomainEvent;
use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserId;

readonly class UserCreated extends DomainEvent
{
    public function __construct(
        UserId $aggregateId,
        \DateTimeImmutable $occurredOn,
        public Email $email,
    ) {
        parent::__construct($aggregateId, $occurredOn);
    }
}
