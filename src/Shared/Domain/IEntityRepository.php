<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * @template Entity
 * @template EntityId
 */
interface IEntityRepository
{
    /**
     * @param Entity $entity
     */
    public function save($entity): void;

    /**
     * @param EntityId $id
     * @return Entity|null
     */
    public function findById($id);
}
