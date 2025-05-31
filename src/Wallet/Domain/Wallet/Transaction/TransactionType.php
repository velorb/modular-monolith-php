<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Transaction;

enum TransactionType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
}
