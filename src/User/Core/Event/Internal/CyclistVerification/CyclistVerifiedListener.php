<?php

declare(strict_types=1);

namespace App\User\Core\Event\Internal\CyclistVerification;

use App\Shared\Application\Bus\Event\IEventBus;
use App\Shared\Application\Event\Integration\User\CyclistVerifiedIE;
use App\User\Core\CyclistVerification\Event\CyclistVerified;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * @TODO: Add verification status — either directly to the User entity
 * * or by introducing a new (e.g. CyclistProfile).
 * * Then, update the status in response to CyclistVerifiedIE.
 */
#[AsEventListener]
class CyclistVerifiedListener
{
    public function __construct(
        private readonly IEventBus $eventBus,
    ) {
    }

    public function __invoke(CyclistVerified $event): void
    {
        $this->eventBus->dispatch(
            new CyclistVerifiedIE(
                $event->userId,
                $event->occurredAt,
            )
        );
    }
}
