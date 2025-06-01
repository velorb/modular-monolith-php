<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification;

enum CyclistVerificationStep: string
{
    case STARTED = 'started';
    case PROFILE_DATA_VERIFIED = 'profile_data_verified';
    case WALLET_MINIMUM_BALANCE_REACHED = 'wallet_minimum_balance_reached';
    case COMPLETED = 'completed';
}
