<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\DAL\Repository;

use App\Shared\Infrastructure\DAL\Repository\DoctrineEntityRepository;
use App\Wallet\Domain\Wallet\IWalletRepository;
use App\Wallet\Domain\Wallet\Wallet;
use App\Wallet\Domain\Wallet\WalletId;

/**
 * @extends DoctrineEntityRepository<Wallet, WalletId>
 */
class WalletDoctrineRepository extends DoctrineEntityRepository implements IWalletRepository
{
    public static function getEntityClassName(): string
    {
        return Wallet::class;
    }
}
