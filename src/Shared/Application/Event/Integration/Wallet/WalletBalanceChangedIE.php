<?php

declare(strict_types=1);

namespace App\Shared\Application\Event\Integration\Wallet;

use App\Shared\Application\Bus\Event\IModuleIntegrationEvent;
use App\Shared\Domain\Money;
use App\Shared\Domain\User\UserId;

readonly class WalletBalanceChangedIE implements IModuleIntegrationEvent
{
    public function __construct(
        public UserId $userId,
        public Money $balance,
    ) {
    }
}
