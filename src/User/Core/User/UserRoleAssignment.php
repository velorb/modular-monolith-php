<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\User\UserId;
use App\Shared\Domain\User\UserRole;

class UserRoleAssignment
{
    public ?int $id;
    private UserId $userId;

    public function __construct(
        private User $user,
        private readonly UserRole $role
    ) {
        $this->userId = $user->getId();
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
}
