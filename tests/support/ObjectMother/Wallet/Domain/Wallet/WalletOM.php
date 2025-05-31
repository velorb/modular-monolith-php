<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Wallet\Domain\Wallet;

use App\Shared\Domain\User\UserId;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Wallet\Domain\Wallet\Wallet;

class WalletOM
{
    public static function create(?UserId $userId = null): Wallet
    {
        return Wallet::create(
            WalletIdOM::random(),
            $userId ?? UserIdOM::random(),
            new ClockMock(),
        );
    }
}
