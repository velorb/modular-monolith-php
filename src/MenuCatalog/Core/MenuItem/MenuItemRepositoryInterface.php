<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\MenuItem;

use App\Shared\Domain\MenuCatalog\MenuItemId;

interface MenuItemRepositoryInterface
{
    public function save(MenuItem $menuItem): void;

    public function findById(MenuItemId $id): ?MenuItem;
}
