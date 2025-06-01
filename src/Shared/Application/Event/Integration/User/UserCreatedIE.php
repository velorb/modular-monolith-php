<?php

declare(strict_types=1);

namespace App\Shared\Application\Event\Integration\User;

use App\Shared\Application\Bus\Event\IModuleIntegrationEvent;
use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserId;

readonly class UserCreatedIE implements IModuleIntegrationEvent
{
    public function __construct(
        public UserId $userId,
        public Email $email,
        public \DateTimeImmutable $occurredAt,
    ) {
    }
}
