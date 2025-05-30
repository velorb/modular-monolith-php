<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Security\Sso;

use App\Shared\Domain\Email;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\User\UserRole;
use App\User\Core\User\UserSsoId;

class SsoPayloadFactory
{
    /**
     * @param mixed[] $payload
     */
    public function createPayloadDto(array $payload): SsoPayloadDto
    {
        $roles = [];

        if (isset($payload['realm_access'])
            && is_array($payload['realm_access'])
            && isset($payload['realm_access']['roles'])
            && is_array($payload['realm_access']['roles'])) {
            $roles = array_merge($roles, $payload['realm_access']['roles']);
        }

        if (isset($payload['resource_access']) && is_array($payload['resource_access'])) {
            foreach ($payload['resource_access'] as $resource) {
                if (is_array($resource) && isset($resource['roles']) && is_array($resource['roles'])) {
                    $roles = array_merge($roles, $resource['roles']);
                }
            }
        }

        $roles = array_map(function ($role) {
            $roleStr = (string)$role; // @phpstan-ignore-line

            return str_starts_with($roleStr, 'ROLE_') ? $roleStr : 'ROLE_' . strtoupper($roleStr);
        }, $roles);

        $roles = array_unique($roles);

        $roles = array_map(
            function ($role): UserRole {
                return UserRole::from((string)$role);
            },
            array_filter($roles, function ($role): bool {
                return UserRole::tryFrom((string)$role) !== null;
            })
        );

        // Validate required fields
        if (!isset($payload['sub']) || !is_string($payload['sub'])) {
            throw new DomainException('Missing or invalid subject identifier in SSO payload');
        }
        $ssoId = new UserSsoId($payload['sub']);

        // Handle username with fallbacks
        $username = '';
        if (isset($payload['preferred_username']) && is_string($payload['preferred_username'])) {
            $username = $payload['preferred_username'];
        } elseif (isset($payload['username']) && is_string($payload['username'])) {
            $username = $payload['username'];
        }

        // Check for required email
        if (!isset($payload['email']) || !is_string($payload['email'])) {
            throw new DomainException('Missing or invalid email in SSO payload');
        }
        $email = new Email($payload['email']);

        // Check for name components
        if (!isset($payload['given_name']) || !is_string($payload['given_name'])) {
            throw new DomainException('Missing or invalid given_name in SSO payload');
        }

        if (!isset($payload['family_name']) || !is_string($payload['family_name'])) {
            throw new DomainException('Missing or invalid family_name in SSO payload');
        }

        return new SsoPayloadDto(
            $ssoId,
            $username,
            $email,
            $roles,
            $payload['given_name'],
            $payload['family_name']
        );
    }
}
