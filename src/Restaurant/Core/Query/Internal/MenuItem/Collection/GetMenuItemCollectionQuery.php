<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Query\Internal\MenuItem\Collection;

use App\Shared\Application\Bus\Query\IQuery;
use App\Shared\Application\DAL\ReadRepository\Pagination;
use App\Shared\Application\ReadRepository\PaginatedCollectionDto;

/**
 * @implements IQuery<PaginatedCollectionDto<MenuItemCollectionElementDto>>
 */
final readonly class GetMenuItemCollectionQuery implements IQuery
{
    public function __construct(
        public Pagination $pagination,
    ) {
    }
}
