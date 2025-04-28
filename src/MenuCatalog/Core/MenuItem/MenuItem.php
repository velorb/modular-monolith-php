<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\MenuItem;

use App\Shared\Domain\MenuCatalog\MenuItemId;
use App\Shared\Domain\Money;

class MenuItem
{
    public function __construct(
        public MenuItemId $id,
        public string $name,
        public Money $price,
    ) {
    }
}
