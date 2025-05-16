<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping\MenuItem;

use App\Shared\Domain\Restaurant\MenuItemId;
use App\Shared\Infrastructure\DAL\Mapping\DoctrineUlidType;

class MenuItemIdType extends DoctrineUlidType
{
    protected function getValueObjectClassName(): string
    {
        return MenuItemId::class;
    }

    public function getName(): string
    {
        return 's__restaurant_menu_item_id';
    }
}
