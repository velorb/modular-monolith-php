<?php

declare(strict_types=1);

namespace App\Shared\Domain;

abstract class AggregateRoot
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];

    public function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
