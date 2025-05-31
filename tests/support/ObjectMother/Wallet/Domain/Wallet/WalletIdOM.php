<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Wallet\Domain\Wallet;

use App\Tests\Support\Faker\UlidFaker;
use App\Wallet\Domain\Wallet\WalletId;

class WalletIdOM
{
    public static function random(): WalletId
    {
        return new WalletId(UlidFaker::generate());
    }
}
