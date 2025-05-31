<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\User\UserSsoId;

/**
 * @extends IEntityRepository<User, UserId>
 */
interface IUserRepository extends IEntityRepository
{
    public function findBySsoId(UserSsoId $ssoId): ?User;

    public function findByUsername(string $username): ?User;
}
