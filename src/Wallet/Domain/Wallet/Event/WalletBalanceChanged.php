<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Event;

use App\Shared\Domain\DomainEvent;
use App\Wallet\Domain\Wallet\WalletId;

readonly class WalletBalanceChanged extends DomainEvent
{
    public function __construct(
        WalletId $aggregateId,
        \DateTimeImmutable $occurredOn
    ) {
        parent::__construct($aggregateId, $occurredOn);
    }
}
