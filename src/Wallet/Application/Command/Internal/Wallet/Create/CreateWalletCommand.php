<?php

declare(strict_types=1);

namespace App\Wallet\Application\Command\Internal\Wallet\Create;

use App\Shared\Application\Bus\Command\ICommand;
use App\Shared\Domain\User\UserId;
use App\Wallet\Domain\Wallet\WalletId;

readonly class CreateWalletCommand implements ICommand
{
    public function __construct(
        public WalletId $walletId,
        public UserId $userId,
    ) {
    }
}
