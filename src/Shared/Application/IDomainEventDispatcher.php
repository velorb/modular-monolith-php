<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\DomainEvent;

interface IDomainEventDispatcher
{
    public function dispatch(DomainEvent ...$events): void;
}
