<?php

declare(strict_types=1);

namespace App\Shared\Domain\User;

enum UserRole: string
{
    case CYCLIST = 'ROLE_CYCLIST';
    case ADMIN = 'ROLE_BACKOFFICE_ADMIN';
}
