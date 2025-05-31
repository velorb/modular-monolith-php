<?php

declare(strict_types=1);

namespace App\Tests\Support\Mock\Shared\Application\Bus\Event;

use App\Shared\Application\Bus\Event\IEvent;
use App\Shared\Application\Bus\Event\IEventBus;

class EventBusMock implements IEventBus
{
    /**
     * @var IEvent[]
     */
    private array $dispatchedEvents = [];

    public function dispatch(IEvent $event): void
    {
        $this->dispatchedEvents[] = $event;
    }

    public function hasDispatchedEvent(callable $predicate): bool
    {
        foreach ($this->dispatchedEvents as $dispatchedEvent) {
            if ($predicate($dispatchedEvent)) {
                return true;
            }
        }

        return false;
    }
}
