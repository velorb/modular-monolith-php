<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Wallet\Domain\Wallet;

use App\Shared\Domain\User\UserSsoId;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserSsoIdOM;
use App\Wallet\Domain\Wallet\Wallet;

class WalletOM
{
    public static function create(?UserSsoId $userSsoId = null): Wallet
    {
        return Wallet::create(
            WalletIdOM::random(),
            $userSsoId ?? UserSsoIdOM::random(),
            new ClockMock(),
        );
    }
}
