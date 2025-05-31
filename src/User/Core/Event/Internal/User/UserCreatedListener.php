<?php

declare(strict_types=1);

namespace App\User\Core\Event\Internal\User;

use App\Shared\Application\Bus\Event\IEventBus;
use App\User\Core\Event\Integration\UserCreatedIE;
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
                $event->aggregateId->value,
                $event->email->value()
            )
        );
    }
}
