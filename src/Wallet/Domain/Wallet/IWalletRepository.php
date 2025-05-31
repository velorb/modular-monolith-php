<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet;

use App\Shared\Domain\IEntityRepository;

/**
 * @extends  IEntityRepository<Wallet, WalletId>
 */
interface IWalletRepository extends IEntityRepository
{
}
