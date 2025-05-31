<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User\Me;

use App\Shared\Application\Bus\Query\IQueryHandler;
use App\Shared\Application\Exception\NotFoundException;
use App\User\Core\Query\Internal\User\Dto\UserDto;
use App\User\Core\Query\Internal\User\IUserReadRepository;

class GetMeHandler implements IQueryHandler
{
    public function __construct(
        private readonly IUserReadRepository $userReadRepository
    ) {
    }

    public function __invoke(GetMeQuery $query): UserDto
    {
        $user = $this->userReadRepository->getDetail($query->ssoId);
        NotFoundException::throwIfNull($user, 'User');

        return $user;
    }
}
