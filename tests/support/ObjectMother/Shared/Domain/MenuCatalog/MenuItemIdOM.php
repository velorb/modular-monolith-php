<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain\MenuCatalog;

use App\Shared\Domain\MenuCatalog\MenuItemId;
use App\Tests\Support\Faker\UlidFaker;

class MenuItemIdOM
{
    public static function random(): MenuItemId
    {
        return new MenuItemId(UlidFaker::generate());
    }
}
