<?php

declare(strict_types=1);

namespace App\User\Core\Event\Integration\Wallet\WalletBalanceChangedIE;

use App\Shared\Application\Event\Integration\Wallet\WalletBalanceChangedIE;
use App\User\Core\CyclistVerification\CyclistVerificationSaga;

class CyclistVerificationSagaWalletBalanceListener
{
    public function __construct(
        private readonly CyclistVerificationSaga $cyclistVerificationSaga
    ) {
    }

    public function __invoke(WalletBalanceChangedIE $event): void
    {
        $this->cyclistVerificationSaga->handleWalletBalanceChanged($event);
    }
}
