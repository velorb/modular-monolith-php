<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Repository;

use App\Shared\Domain\User\UserId;
use App\User\Core\User\IUserRepository;
use App\User\Core\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserDoctrineRepository extends ServiceEntityRepository implements IUserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findById(UserId $userId): ?User
    {
        return $this->find($userId);
    }
}
