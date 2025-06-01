<?php

declare(strict_types=1);

namespace App\User\Core\Event\Internal\User;

use App\Shared\Application\Bus\Event\IEventBus;
use App\Shared\Application\Event\Integration\User\UserCreatedIE;
use App\Shared\Domain\User\UserId;
use App\User\Core\User\Event\UserCreated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class UserCreatedListener
{
    public function __construct(
        private readonly IEventBus $eventBus,
    ) {
    }

    public function __invoke(UserCreated $event): void
    {
        $this->eventBus->dispatch(
            new UserCreatedIE(
                new UserId($event->aggregateId->value),
                $event->email,
                $event->occurredAt,
            )
        );
    }
}
