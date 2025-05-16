<?php

declare(strict_types=1);

namespace App\Restaurant\Core\MenuItem;

use App\Shared\Domain\Restaurant\MenuItemId;
use App\Shared\Domain\Price;

class MenuItem
{
    public function __construct(
        private MenuItemId $id,
        private string $name,
        private Price $price,
    ) {
    }

    public function update(string $name, Price $price): void
    {
        $this->name = $name;
        $this->price = $price;
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
