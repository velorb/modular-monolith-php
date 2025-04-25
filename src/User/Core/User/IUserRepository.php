<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\User\UserId;

interface IUserRepository
{
    public function save(User $user): void;

    public function findById(UserId $userId): ?User;
}
