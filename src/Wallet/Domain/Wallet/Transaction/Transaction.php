<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Transaction;

use App\Shared\Domain\Money;
use App\Wallet\Domain\Wallet\Wallet;

readonly class Transaction
{
    /**
     * @phpstan-ignore-next-line
     */
    private int $id;

    public function __construct(
        private Wallet $wallet, // @phpstan-ignore-line
        private Money $amount,
        private TransactionType $type,
        private TransactionAuthor $createdBy,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public function toDto(): TransactionDto
    {
        return new TransactionDto(
            $this->amount,
            $this->type,
            $this->createdBy,
            $this->createdAt,
        );
    }
}
