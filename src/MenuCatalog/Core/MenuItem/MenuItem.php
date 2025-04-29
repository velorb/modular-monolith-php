<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\MenuItem;

use App\Shared\Domain\MenuCatalog\MenuItemId;
use App\Shared\Domain\Price;

final class MenuItem
{
    public function __construct(
        private MenuItemId $id,
        private string $name,
        private Price $price,
    ) {
    }

    public function getId(): MenuItemId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
