<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User;

use App\Shared\Domain\User\UserSsoId;
use App\User\Core\Query\Internal\User\Dto\UserDto;

interface IUserReadRepository
{
    public function getDetail(UserSsoId $ssoId): ?UserDto;
}
