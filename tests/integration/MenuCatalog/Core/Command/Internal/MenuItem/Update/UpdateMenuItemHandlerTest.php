<?php

declare(strict_types=1);

namespace App\Tests\Integration\MenuCatalog\Core\Command\Internal\MenuItem\Update;

use App\MenuCatalog\Core\Command\Internal\MenuItem\MenuItemDto;
use App\MenuCatalog\Core\Command\Internal\MenuItem\Update\UpdateMenuItemCommand;
use App\MenuCatalog\Core\Command\Internal\MenuItem\Update\UpdateMenuItemHandler;
use App\MenuCatalog\Core\MenuItem\IMenuItemRepository;
use App\Shared\Domain\Money;
use App\Shared\Domain\Price;
use App\Shared\Domain\VatRate;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\MenuCatalog\MenuItem\MenuItemOM;
use PHPUnit\Framework\Attributes\Test;

class UpdateMenuItemHandlerTest extends IntegrationTestCase
{
    private UpdateMenuItemHandler $createMenuItemHandler;
    private IMenuItemRepository $menuItemRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createMenuItemHandler = self::getServiceByClassName(UpdateMenuItemHandler::class);
        $this->menuItemRepository = self::getServiceByClassName(IMenuItemRepository::class);
    }

    #[Test]
    public function it_creates_menu_item(): void
    {
        $menuItem = MenuItemOM::create(
            'name',
            new Price(
                Money::fromCents(1000),
                VatRate::fromBasisPoints(8000)
            )
        );
        $this->menuItemRepository->save($menuItem);
        $this->clearEntityManager();

        $this->createMenuItemHandler->__invoke(
            new UpdateMenuItemCommand(
                new MenuItemDto(
                    $menuItem->getId(),
                    'other-name',
                    new Price(
                        Money::fromCents(2000),
                        VatRate::fromBasisPoints(1000)
                    )
                )
            )
        );
        $this->clearEntityManager();
        $menuItemDb = $this->menuItemRepository->findById($menuItem->getId());
        $this->assertNotNull($menuItemDb);
        $this->assertEquals('other-name', $menuItemDb->getName());
        $this->assertEquals(Money::fromCents(2000), $menuItemDb->getPrice()->net);
        $this->assertEquals(VatRate::fromBasisPoints(1000), $menuItemDb->getPrice()->vatRate);
    }
}
