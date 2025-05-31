<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Application\Bus\Event\IEvent;
use App\Shared\Application\Bus\Event\IEventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus implements IEventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(IEvent $event): void
    {
        $this->eventBus->dispatch(Envelope::wrap($event));
    }
}
