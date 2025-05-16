<?php

declare(strict_types=1);

namespace App\Restaurant\Infrastructure\DAL\Repository;

use App\Restaurant\Core\MenuItem\IMenuItemRepository;
use App\Restaurant\Core\MenuItem\MenuItem;
use App\Shared\Domain\Restaurant\MenuItemId;
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
