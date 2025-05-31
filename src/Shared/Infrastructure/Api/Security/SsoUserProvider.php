<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Security;

use App\Shared\Application\Bus\Command\ICommandBus;
use App\Shared\Infrastructure\Api\Security\Sso\SsoPayloadFactory;
use App\User\Core\Command\Internal\CreateUserFromSso\CreateUserFromSsoCommand;
use App\User\Core\User\IUserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements  UserProviderInterface<SecurityUser>
 */
class SsoUserProvider implements UserProviderInterface, PayloadAwareUserProviderInterface
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly ICommandBus $commandBus,
        private readonly SsoPayloadFactory $payloadFactory,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass(string $class): bool
    {
        return $class === SecurityUser::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param mixed[] $payload
     */
    public function loadUserByIdentifierAndPayload(string $identifier, array $payload): UserInterface
    {
        $ssoPayload = $this->payloadFactory->createPayloadDto($payload);

        /**
         * @todo for simplicity - later move user creation to sso event in user module.
         */
        $user = $this->userRepository->findBySsoId($ssoPayload->userSsoId);
        if ($user === null) {
            $this->commandBus->dispatch(
                new CreateUserFromSsoCommand(
                    $ssoPayload->userSsoId,
                    $ssoPayload->username,
                    $ssoPayload->email,
                    $ssoPayload->roles,
                    $ssoPayload->firstName,
                    $ssoPayload->lastName
                )
            );
        }

        return new SecurityUser(
            $ssoPayload->userSsoId,
            $ssoPayload->email,
            $ssoPayload->roles
        );
    }
}
