<?php

declare(strict_types=1);

namespace App\User\Core\Command\Internal\CreateUserFromSso;

use App\Shared\Application\Bus\Command\ICommandHandler;
use App\Shared\Application\Exception\ValidationFailedException;
use App\Shared\Domain\Id\IUlidGenerator;
use App\Shared\Domain\User\UserId;
use App\User\Core\User\IUserRepository;
use App\User\Core\User\User;

class CreateUserFromSsoHandler implements ICommandHandler
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly IUlidGenerator $ulidGenerator,
    ) {
    }

    public function __invoke(CreateUserFromSsoCommand $command): void
    {
        $user = $this->userRepository->findBySsoId($command->ssoId);
        if ($user !== null) {
            throw new ValidationFailedException('User with this SSO ID already exists.');
        }

        $user = User::createFromSso(
            UserId::fromUlid($this->ulidGenerator->new()),
            $command->ssoId,
            $command->username,
            $command->email,
            $command->roles,
            $command->firstName,
            $command->lastName
        );

        $this->userRepository->save($user);
    }
}
