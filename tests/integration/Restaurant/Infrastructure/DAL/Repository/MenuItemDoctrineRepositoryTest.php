<?php

declare(strict_types=1);

namespace App\Tests\Integration\Restaurant\Infrastructure\DAL\Repository;

use App\Restaurant\Core\MenuItem\MenuItem;
use App\Restaurant\Infrastructure\DAL\Repository\MenuItemDoctrineRepository;
use App\Shared\Domain\Money;
use App\Shared\Domain\Price;
use App\Shared\Domain\VatRate;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\Restaurant\MenuItemIdOM;
use PHPUnit\Framework\Attributes\Test;

class MenuItemDoctrineRepositoryTest extends IntegrationTestCase
{
    private MenuItemDoctrineRepository $menuItemRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->menuItemRepository = self::getServiceByClassName(MenuItemDoctrineRepository::class);
    }

    #[Test]
    public function menu_item_can_be_saved_and_retrieved(): void
    {
        $menuItem = new MenuItem(
            MenuItemIdOM::random(),
            'pizza diavola',
            new Price(
                Money::fromCents(1000),
                VatRate::fromBasisPoints(800)
            )
        );

        $this->menuItemRepository->save($menuItem);
        $this->clearEntityManager();
        $menuItemDb = $this->menuItemRepository->find($menuItem->getId());
        $this->assertNotNull($menuItemDb);
        $this->assertEquals($menuItem->getId(), $menuItemDb->getId());
        $this->assertEquals($menuItem->getName(), $menuItemDb->getName());
        $this->assertEquals(1000, $menuItem->getPrice()->net->amount);
        $this->assertEquals(1080, $menuItem->getPrice()->gross->amount);
        $this->assertEquals(VatRate::fromBasisPoints(800), $menuItem->getPrice()->vatRate);
    }
}
