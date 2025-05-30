<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Repository;

use App\Shared\Domain\User\UserId;
use App\Shared\Infrastructure\DAL\Repository\DoctrineEntityRepository;
use App\User\Core\User\IUserRepository;
use App\User\Core\User\User;
use App\User\Core\User\UserSsoId;

/**
 * @extends DoctrineEntityRepository<User, UserId>
 */
class UserDoctrineRepository extends DoctrineEntityRepository implements IUserRepository
{
    public static function getEntityClassName(): string
    {
        return User::class;
    }

    public function findBySsoId(UserSsoId $ssoId): ?User
    {
        return $this->findOneBy(['ssoId' => $ssoId]);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }
}
