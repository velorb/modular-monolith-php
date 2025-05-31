<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User\Me;

use App\Shared\Application\Bus\Query\IQuery;
use App\Shared\Domain\User\UserSsoId;
use App\User\Core\Query\Internal\User\Dto\UserDto;

/**
 * @implements IQuery<UserDto>
 */
readonly class GetMeQuery implements IQuery
{
    public function __construct(public UserSsoId $ssoId)
    {
    }
}
