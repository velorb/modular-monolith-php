<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Query\Internal\MenuItem;

use App\Restaurant\Core\Query\Internal\MenuItem\Collection\MenuItemCollectionElementDto;
use App\Shared\Application\DAL\ReadRepository\Pagination;
use App\Shared\Application\ReadRepository\PaginatedCollectionDto;

interface IMenuItemReadRepository
{
    /**
     * @return PaginatedCollectionDto<MenuItemCollectionElementDto>
     */
    public function getCollection(Pagination $pagination): PaginatedCollectionDto;
}
