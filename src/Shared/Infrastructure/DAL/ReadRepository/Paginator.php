<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\ReadRepository;

use App\Shared\Application\DAL\ReadRepository\Pagination;
use App\Shared\Application\ReadRepository\PaginatedCollectionDto;
use App\Shared\Application\ReadRepository\PaginationDto;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class Paginator
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    /**
     * @template TDto
     * @param callable(array<string,mixed>): TDto $mapRowToDto
     * @return PaginatedCollectionDto<TDto>
     */
    public function paginate(QueryBuilder $qb, callable $mapRowToDto, Pagination $pagination): PaginatedCollectionDto
    {
        /** @var int $totalItems */
        $totalItems = $this->connection->executeQuery(
            'SELECT COUNT(*) from (' . $qb->getSQL() . ')',
            $qb->getParameters(),
            $qb->getParameterTypes(),
        )->fetchOne();

        $firstResult = ($pagination->currentPage - 1) * $pagination->pageSize;
        $result = $qb->setFirstResult($firstResult)
            ->setMaxResults($pagination->pageSize)
            ->executeQuery()
            ->fetchAllAssociative();

        return new PaginatedCollectionDto(
            array_map(
                $mapRowToDto,
                $result,
            ),
            new PaginationDto(
                $pagination->currentPage,
                $pagination->pageSize,
                $totalItems,
            ),
        );
    }
}
