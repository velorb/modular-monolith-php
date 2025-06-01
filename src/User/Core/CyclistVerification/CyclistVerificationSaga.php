<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification;

use App\Shared\Application\Event\Integration\Wallet\WalletBalanceChangedIE;
use App\Shared\Application\IDomainEventDispatcher;
use App\Shared\Domain\IClock;
use App\Shared\Domain\User\UserId;
use App\User\Core\User\Event\UserAddressChanged;
use App\User\Core\User\IUserRepository;
use App\User\Core\User\User;

class CyclistVerificationSaga
{
    public function __construct(
        private readonly ICyclistVerificationProcessRepository $processRepository,
        private readonly IUserRepository $userRepository,
        private readonly IDomainEventDispatcher $dispatcher,
        private readonly IClock $clock,
    ) {
    }

    public function start(CyclistVerificationProcessId $id, UserId $userId): void
    {
        /** @var User $user */
        $user = $this->userRepository->findById($userId);
        $process = $this->processRepository->findActiveByUserId($userId);
        if (!$this->validateCanStartVerificationProcess($user, $process)) {
            return;
        }

        $process = CyclistVerificationProcess::start(
            $id,
            $userId,
            $this->clock,
        );
        $this->processRepository->save($process);
    }

    public function handleWalletBalanceChanged(WalletBalanceChangedIE $balanceChangedIE): void
    {
        $process = $this->processRepository->findActiveByUserId($balanceChangedIE->userId);
        if ($process === null) {
            return;
        }

        $process->verifyWalletBalance($balanceChangedIE->balance, $this->clock);
        $this->processRepository->save($process);
        $this->dispatchDomainEvents($process);
    }

    public function handleAddressChanged(UserAddressChanged $addressChanged): void
    {
        /** @var UserId $userId */
        $userId = $addressChanged->aggregateId;
        $process = $this->processRepository->findActiveByUserId($userId);
        if ($process === null) {
            return;
        }

        $process->markProfileDataFulfilled($this->clock);
        $this->processRepository->save($process);
        $this->dispatchDomainEvents($process);
    }

    private function dispatchDomainEvents(CyclistVerificationProcess $process): void
    {
        $this->dispatcher->dispatch(...$process->pullEvents());
    }

    private function validateCanStartVerificationProcess(User $user, ?CyclistVerificationProcess $activeProcess): bool
    {
        return $user->isCyclist() && $activeProcess === null;
    }
}
