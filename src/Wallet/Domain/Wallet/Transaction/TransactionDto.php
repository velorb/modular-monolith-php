<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Transaction;

use App\Shared\Domain\Money;

readonly class TransactionDto
{
    public function __construct(
        public Money $amount,
        public TransactionType $type,
        public TransactionAuthor $createdBy,
        public \DateTimeImmutable $createdAt,
    ) {
    }
}
