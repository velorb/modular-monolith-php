<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Repository;

use App\Shared\Domain\User\UserId;
use App\Shared\Infrastructure\DAL\Repository\DoctrineEntityRepository;
use App\User\Core\User\IUserEntityRepository;
use App\User\Core\User\User;

/**
 * @extends DoctrineEntityRepository<User, UserId>
 */
class UserDoctrineRepository extends DoctrineEntityRepository implements IUserEntityRepository
{
    public static function getEntityClassName(): string
    {
        return User::class;
    }
}
