<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\DAL\Repository;

use App\MenuCatalog\Core\MenuItem\MenuItem;
use App\MenuCatalog\Core\MenuItem\MenuItemRepositoryInterface;
use App\Shared\Domain\MenuCatalog\MenuItemId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuItem>
 */
class MenuItemDoctrineRepository extends ServiceEntityRepository implements MenuItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItem::class);
    }

    public function save(MenuItem $menuItem): void
    {
        $this->getEntityManager()->persist($menuItem);
        $this->getEntityManager()->flush();
    }

    public function findById(MenuItemId $id): ?MenuItem
    {
        return $this->find($id);
    }
}
