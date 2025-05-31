<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\AggregateVersionTrait;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\IClock;
use App\Shared\Domain\ModificationDatesTrait;
use App\Shared\Domain\Money;
use App\Shared\Domain\User\UserId;
use App\Wallet\Domain\Wallet\Transaction\Transaction;
use App\Wallet\Domain\Wallet\Transaction\TransactionAuthor;
use App\Wallet\Domain\Wallet\Transaction\TransactionDto;
use App\Wallet\Domain\Wallet\Transaction\TransactionType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Wallet extends AggregateRoot
{
    use AggregateVersionTrait;
    use ModificationDatesTrait;

    private const int MAX_BALANCE_CENTS = 10_000_00;

    /**
     * @var Collection<int, Transaction>
     */
    private Collection $transactions;

    private function __construct(
        private WalletId $id,
        private UserId $userId,
        private Money $balance,
        IClock $clock
    ) {
        $this->transactions = new ArrayCollection();
        $now = $clock->now();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public static function create(WalletId $walletId, UserId $userId, IClock $clock): self
    {
        return new self($walletId, $userId, Money::fromCents(0), $clock);
    }

    public function deposit(Money $money, TransactionAuthor $author, IClock $clock): void
    {
        $this->validateAmountIsGreaterThanZero($money);
        $this->validateMaximumBalanceNotExceeded($money, $author);

        $this->transactions->add(
            new Transaction($this, $money, TransactionType::DEPOSIT, $author, $clock->now())
        );
        $this->balance = $this->balance->add($money);
        $this->updatedAt = $clock->now();
    }

    public function withdraw(Money $money, TransactionAuthor $author, IClock $clock): void
    {
        $this->validateAmountIsGreaterThanZero($money);

        $this->transactions->add(
            new Transaction($this, $money, TransactionType::WITHDRAWAL, $author, $clock->now())
        );
        $this->balance = $this->balance->sub($money);
        $this->updatedAt = $clock->now();
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }

    public function getId(): WalletId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * This is to prevent modify transactions outside the wallet.
     *
     * @return TransactionDto[]
     */
    public function getTransactions(): array
    {
        return $this->transactions->map(fn (Transaction $transaction) => $transaction->toDto())->toArray();
    }

    private function validateAmountIsGreaterThanZero(Money $money): void
    {
        if ($money->isLessOrEqualThan(Money::zero())) {
            throw new DomainException('Deposit amount must be greater than zero.');
        }
    }

    private function validateMaximumBalanceNotExceeded(Money $moneyToAdd, TransactionAuthor $author): void
    {
        if ($author->isSystemAuthor()) {
            return;
        }

        if ($this->balance->add($moneyToAdd)->amount > self::MAX_BALANCE_CENTS) {
            throw new DomainException('Deposit exceeds maximum wallet balance.');
        }
    }
}
