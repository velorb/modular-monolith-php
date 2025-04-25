<?php

declare(strict_types=1);

namespace App\Shared\Domain\User;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
