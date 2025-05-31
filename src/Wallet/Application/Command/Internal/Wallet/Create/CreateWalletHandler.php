<?php

declare(strict_types=1);

namespace App\Wallet\Application\Command\Internal\Wallet\Create;

use App\Shared\Application\Bus\Command\ICommandHandler;
use App\Wallet\Domain\Wallet\IWalletRepository;
use App\Wallet\Domain\Wallet\Service\CreateWalletService;

class CreateWalletHandler implements ICommandHandler
{
    public function __construct(
        private IWalletRepository $walletRepository,
        private CreateWalletService $createWalletService,
    ) {
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = $this->createWalletService->create($command->walletId, $command->userId);
        $this->walletRepository->save($wallet);
    }
}
