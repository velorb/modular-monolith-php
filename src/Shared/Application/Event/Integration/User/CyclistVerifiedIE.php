<?php

declare(strict_types=1);

namespace App\Shared\Application\Event\Integration\User;

use App\Shared\Application\Bus\Event\IModuleIntegrationEvent;
use App\Shared\Domain\User\UserId;

readonly class CyclistVerifiedIE implements IModuleIntegrationEvent
{
    public function __construct(public UserId $userId, public \DateTimeImmutable $occurredAt)
    {
    }
}
