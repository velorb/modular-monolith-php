<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\DAL\Mapping;

use App\Shared\Infrastructure\DAL\Mapping\DoctrineUlidType;
use App\Wallet\Domain\Wallet\WalletId;

class WalletIdType extends DoctrineUlidType
{
    protected function getValueObjectClassName(): string
    {
        return WalletId::class;
    }

    public function getName(): string
    {
        return 'wallet__wallet_id';
    }
}
