<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\MenuItem;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\MenuCatalog\MenuItemId;

/**
 * @extends IEntityRepository<MenuItem, MenuItemId>
 */
interface IMenuItemRepository extends IEntityRepository
{
}
