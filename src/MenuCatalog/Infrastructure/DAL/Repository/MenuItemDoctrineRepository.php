<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\DAL\Repository;

use App\MenuCatalog\Core\MenuItem\IMenuItemRepository;
use App\MenuCatalog\Core\MenuItem\MenuItem;
use App\Shared\Domain\MenuCatalog\MenuItemId;
use App\Shared\Infrastructure\DAL\Repository\DoctrineEntityRepository;

/**
 * @extends DoctrineEntityRepository<MenuItem, MenuItemId>
 */
class MenuItemDoctrineRepository extends DoctrineEntityRepository implements IMenuItemRepository
{
    public static function getEntityClassName(): string
    {
        return MenuItem::class;
    }
}
