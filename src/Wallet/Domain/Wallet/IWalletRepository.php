<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\User\UserId;

/**
 * @extends  IEntityRepository<Wallet, WalletId>
 */
interface IWalletRepository extends IEntityRepository
{
    public function findByUserId(UserId $userId): ?Wallet;
}
