<?php

declare(strict_types=1);

namespace App\Restaurant\Core\MenuItem;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\Restaurant\MenuItemId;

/**
 * @extends IEntityRepository<MenuItem, MenuItemId>
 */
interface IMenuItemRepository extends IEntityRepository
{
}
