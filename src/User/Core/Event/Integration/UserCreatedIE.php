<?php

declare(strict_types=1);

namespace App\User\Core\Event\Integration;

use App\Shared\Application\Bus\Event\IModuleIntegrationEvent;

readonly class UserCreatedIE implements IModuleIntegrationEvent
{
    public function __construct(
        public string $userId,
        public string $email,
    ) {
    }
}
