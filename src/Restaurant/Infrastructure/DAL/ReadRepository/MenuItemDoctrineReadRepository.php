<?php

declare(strict_types=1);

namespace App\Restaurant\Infrastructure\DAL\ReadRepository;

use App\Restaurant\Core\Query\Internal\MenuItem\Collection\MenuItemCollectionElementDto;
use App\Restaurant\Core\Query\Internal\MenuItem\IMenuItemReadRepository;
use App\Shared\Application\DAL\ReadRepository\Pagination;
use App\Shared\Application\ReadRepository\PaginatedCollectionDto;
use App\Shared\Infrastructure\DAL\ReadRepository\Paginator;
use Doctrine\DBAL\Connection;

class MenuItemDoctrineReadRepository implements IMenuItemReadRepository
{
    public function __construct(
        private readonly Connection $connection,
        private readonly Paginator $paginator,
    ) {
    }

    public function getCollection(Pagination $pagination): PaginatedCollectionDto
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('mi.id', 'mi.name', 'mi.price_gross')
            ->from('restaurant_menu_item', 'mi');

        return $this->paginator->paginate(
            $qb,
            function (array $row): MenuItemCollectionElementDto {
                /** @var array{id: string, name: string, price_gross: int} $row */
                return new MenuItemCollectionElementDto(
                    $row['id'],
                    $row['name'],
                    $row['price_gross']
                );
            },
            $pagination
        );
    }
}
