<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\Query\Internal\MenuItem\Collection;

use App\MenuCatalog\Core\Query\Internal\MenuItem\IMenuItemReadRepository;
use App\Shared\Application\Bus\Query\IQueryHandler;
use App\Shared\Application\ReadRepository\PaginatedCollectionDto;

class GetMenuItemCollectionHandler implements IQueryHandler
{
    public function __construct(
        private readonly IMenuItemReadRepository $menuItemRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionDto<MenuItemCollectionElementDto>
     */
    public function __invoke(GetMenuItemCollectionQuery $query): PaginatedCollectionDto
    {
        return $this->menuItemRepository->getCollection($query->pagination);
    }
}
