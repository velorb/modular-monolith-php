<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Command\Internal\MenuItem;

use App\Shared\Domain\Restaurant\MenuItemId;
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
