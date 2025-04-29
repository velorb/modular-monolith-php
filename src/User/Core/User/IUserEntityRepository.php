<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\User\UserId;

/**
 * @extends IEntityRepository<User, UserId>
 */
interface IUserEntityRepository extends IEntityRepository
{
}
