<?php

declare(strict_types=1);

namespace App\Tests\Integration\MenuCatalog\Infrastructure\DAL\ReadRepository;

use App\MenuCatalog\Core\MenuItem\IMenuItemRepository;
use App\MenuCatalog\Core\Query\Internal\MenuItem\IMenuItemReadRepository;
use App\Shared\Application\DAL\ReadRepository\Pagination;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\MenuCatalog\MenuItem\MenuItemOM;
use PHPUnit\Framework\Attributes\Test;

class MenuItemDoctrineReadRepositoryTest extends IntegrationTestCase
{
    private IMenuItemRepository $menuItemWriteRepository;
    private IMenuItemReadRepository $menuItemReadRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuItemWriteRepository = self::getServiceByClassName(IMenuItemRepository::class);
        $this->menuItemReadRepository = self::getServiceByClassName(IMenuItemReadRepository::class);
    }

    #[Test]
    public function it_paginates_result(): void
    {
        $item1 = MenuItemOM::create();
        $item2 = MenuItemOM::create();
        $this->menuItemWriteRepository->save($item1);
        $this->menuItemWriteRepository->save($item2);

        $result = $this->menuItemReadRepository->getCollection(new Pagination(1, 1));
        $this->assertEquals(2, $result->pagination->totalItems);
        $this->assertEquals(1, $result->pagination->pageSize);
        $this->assertEquals(1, $result->pagination->currentPage);
        $this->assertCount(1, $result->items);
        $this->assertEquals($item1->getId()->value, $result->items[0]->id);

        $result = $this->menuItemReadRepository->getCollection(new Pagination(1, 2));
        $this->assertEquals(2, $result->pagination->currentPage);
        $this->assertCount(1, $result->items);
        $this->assertEquals($item2->getId()->value, $result->items[0]->id);
    }
}
