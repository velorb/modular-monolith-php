<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User;

use App\User\Core\Query\Internal\User\Dto\UserDto;
use App\User\Core\User\UserSsoId;

interface IUserReadRepository
{
    public function getDetail(UserSsoId $ssoId): ?UserDto;
}
