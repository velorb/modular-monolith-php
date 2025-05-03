<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\Command\Internal\MenuItem;

use App\Shared\Domain\MenuCatalog\MenuItemId;
use App\Shared\Domain\Price;

class MenuItemDto
{
    public function __construct(
        public MenuItemId $id,
        public string $name,
        public Price $price,
    ) {
    }
}
