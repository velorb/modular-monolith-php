<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Repository;

use App\Shared\Domain\IEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template Entity of object
 * @template EntityId
 * @extends ServiceEntityRepository<Entity>
 * @implements IEntityRepository<Entity, EntityId>
 */
abstract class DoctrineEntityRepository extends ServiceEntityRepository implements IEntityRepository
{
    /**
     * @return class-string<Entity>
     */
    abstract public static function getEntityClassName(): string;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, static::getEntityClassName());
    }

    public function save($entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findById($id)
    {
        return $this->find($id);
    }
}
