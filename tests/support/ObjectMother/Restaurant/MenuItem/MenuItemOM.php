<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Restaurant\MenuItem;

use App\Restaurant\Core\MenuItem\MenuItem;
use App\Shared\Domain\Money;
use App\Shared\Domain\Price;
use App\Shared\Domain\VatRate;
use App\Tests\Support\ObjectMother\Shared\Domain\Restaurant\MenuItemIdOM;

final class MenuItemOM
{
    public static function create(?string $name = null, ?Price $price = null): MenuItem
    {
        return new MenuItem(
            MenuItemIdOM::random(),
            $name ?? 'name',
            $price ?? new Price(Money::fromCents(1000), VatRate::fromBasisPoints(1000))
        );
    }
}
