<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Transaction;

enum TransactionAuthorType: string
{
    case USER = 'user';
    case SYSTEM = 'system';
}
