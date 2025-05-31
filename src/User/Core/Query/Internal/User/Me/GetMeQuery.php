<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User\Me;

use App\Shared\Application\Bus\Query\IQuery;
use App\User\Core\Query\Internal\User\Dto\UserDto;
use App\User\Core\User\UserSsoId;

/**
 * @implements IQuery<UserDto>
 */
readonly class GetMeQuery implements IQuery
{
    public function __construct(public UserSsoId $ssoId)
    {
    }
}
