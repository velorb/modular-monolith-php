<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\IDomainEventDispatcher;
use App\Shared\Domain\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SymfonyDomainEventDispatcher implements IDomainEventDispatcher
{
    public function __construct(
        private EventDispatcherInterface $dispatcher
    ) {
    }

    public function dispatch(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
