<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Service;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\IClock;
use App\Shared\Domain\User\UserId;
use App\Wallet\Domain\Wallet\IWalletRepository;
use App\Wallet\Domain\Wallet\Wallet;
use App\Wallet\Domain\Wallet\WalletId;

class CreateWalletService
{
    public function __construct(
        private readonly IWalletRepository $walletRepository,
        private readonly IClock $clock,
    ) {
    }

    public function create(WalletId $walletId, UserId $userId): Wallet
    {
        $existingWallet = $this->walletRepository->findByUserId($userId);
        if ($existingWallet !== null) {
            throw new DomainException('Wallet already exists for this user.');
        }

        return Wallet::create($walletId, $userId, $this->clock);
    }
}
