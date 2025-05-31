<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\ReadRepository\User;

use App\User\Core\Query\Internal\User\Dto\UserDto;
use App\User\Core\Query\Internal\User\IUserReadRepository;
use App\User\Core\User\UserSsoId;
use Doctrine\DBAL\Connection;

class UserReadDoctrineRepository implements IUserReadRepository
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function getDetail(UserSsoId $ssoId): ?UserDto
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select(
            'u.sso_id',
            'u.username',
            'u.email',
            'u.first_name',
            'u.last_name',
            "string_agg(DISTINCT r.role, ',') AS roles"
        )
            ->from('user_user', 'u')
            ->join('u', 'user_user_role', 'r', 'u.id = r.user_id')
            ->where('u.sso_id = :ssoId')
            ->setParameter('ssoId', $ssoId->value)
            ->groupBy('u.id');

        /** @var array<string, string|int|bool>|false $result */
        $result = $qb->executeQuery()->fetchAssociative();
        if ($result === false) {
            return null;
        }

        return new UserDto(
            (string)$result['sso_id'],
            (string)$result['username'],
            (string)$result['email'],
            (string)$result['first_name'],
            (string)$result['last_name'],
            explode(',', (string)$result['roles']),
        );
    }
}
