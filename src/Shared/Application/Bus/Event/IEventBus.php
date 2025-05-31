<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus\Event;

interface IEventBus
{
    public function dispatch(IEvent $event): void;
}
