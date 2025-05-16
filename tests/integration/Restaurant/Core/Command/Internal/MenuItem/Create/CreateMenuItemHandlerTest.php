<?php

declare(strict_types=1);

namespace App\Tests\Integration\Restaurant\Core\Command\Internal\MenuItem\Create;

use App\Restaurant\Core\Command\Internal\MenuItem\Create\CreateMenuItemCommand;
use App\Restaurant\Core\Command\Internal\MenuItem\Create\CreateMenuItemHandler;
use App\Restaurant\Core\Command\Internal\MenuItem\MenuItemDto;
use App\Restaurant\Core\MenuItem\IMenuItemRepository;
use App\Shared\Domain\Money;
use App\Shared\Domain\Price;
use App\Shared\Domain\VatRate;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\Restaurant\MenuItemIdOM;
use PHPUnit\Framework\Attributes\Test;

class CreateMenuItemHandlerTest extends IntegrationTestCase
{
    private CreateMenuItemHandler $createMenuItemHandler;
    private IMenuItemRepository $menuItemRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createMenuItemHandler = self::getServiceByClassName(CreateMenuItemHandler::class);
        $this->menuItemRepository = self::getServiceByClassName(IMenuItemRepository::class);
    }

    #[Test]
    public function it_creates_menu_item(): void
    {
        $menuItemId = MenuItemIdOM::random();
        $this->createMenuItemHandler->__invoke(
            new CreateMenuItemCommand(
                new MenuItemDto(
                    $menuItemId,
                    'name',
                    new Price(
                        Money::fromCents(1000),
                        VatRate::fromBasisPoints(8000)
                    )
                )
            )
        );
        $this->clearEntityManager();
        $menuItem = $this->menuItemRepository->findById($menuItemId);
        $this->assertNotNull($menuItem);
        $this->assertEquals($menuItemId, $menuItem->getId());
        $this->assertEquals('name', $menuItem->getName());
        $this->assertEquals(Money::fromCents(1000), $menuItem->getPrice()->net);
        $this->assertEquals(VatRate::fromBasisPoints(8000), $menuItem->getPrice()->vatRate);
    }
}
