<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Query\Internal\MenuItem\Collection;

final readonly class MenuItemCollectionElementDto
{
    public function __construct(
        public string $id,
        public string $name,
        public int $priceGross,
    ) {
    }
}
