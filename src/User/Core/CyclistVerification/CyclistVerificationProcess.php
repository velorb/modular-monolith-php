<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\AggregateVersionTrait;
use App\Shared\Domain\IClock;
use App\Shared\Domain\Money;
use App\Shared\Domain\User\UserId;
use App\User\Core\CyclistVerification\Event\CyclistVerified;

class CyclistVerificationProcess extends AggregateRoot
{
    use AggregateVersionTrait;

    private const int MINIMUM_WALLET_BALANCE_CENTS = 20_00;

    /**
     * @param CyclistVerificationHistory[] $history
     */
    private function __construct(
        private readonly CyclistVerificationProcessId $id,
        private readonly UserId $userId,
        private bool $profileDataVerified = false,
        private bool $walletMinimumBalanceReached = false,
        private bool $completed = false,
        private array $history = [],
    ) {
    }

    public static function start(CyclistVerificationProcessId $id, UserId $userId, IClock $clock): self
    {
        $process = new self(
            $id,
            $userId,
        );
        $process->recordHistory(CyclistVerificationStep::STARTED, $clock->now());

        return $process;
    }

    public function markProfileDataFulfilled(IClock $clock): void
    {
        if ($this->profileDataVerified) {
            return;
        }

        $this->profileDataVerified = true;
        $this->recordHistory(CyclistVerificationStep::PROFILE_DATA_VERIFIED, $clock->now());
        $this->tryComplete($clock->now());
    }

    public function verifyWalletBalance(Money $balance, IClock $clock): void
    {
        if ($this->walletMinimumBalanceReached) {
            return;
        }

        if ($balance->isGreaterOrEqual(Money::fromCents(self::MINIMUM_WALLET_BALANCE_CENTS))) {
            $this->walletMinimumBalanceReached = true;
            $this->recordHistory(CyclistVerificationStep::WALLET_MINIMUM_BALANCE_REACHED, $clock->now());
            $this->tryComplete($clock->now());
        }
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function isProfileDataVerified(): bool
    {
        return $this->profileDataVerified;
    }

    public function isWalletMinimumBalanceReached(): bool
    {
        return $this->walletMinimumBalanceReached;
    }

    /**
     * @return CyclistVerificationHistory[]
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getId(): CyclistVerificationProcessId
    {
        return $this->id;
    }

    private function tryComplete(\DateTimeImmutable $occurredAt): void
    {
        if ($this->profileDataVerified && $this->walletMinimumBalanceReached && !$this->completed) {
            $this->completed = true;
            $this->recordHistory(CyclistVerificationStep::COMPLETED, $occurredAt);
            $this->record(new CyclistVerified($this->id, $occurredAt, $this->userId));
        }
    }

    private function recordHistory(CyclistVerificationStep $step, \DateTimeImmutable $occurredAt): void
    {
        $this->history[] = new CyclistVerificationHistory($step, $occurredAt);
    }
}
