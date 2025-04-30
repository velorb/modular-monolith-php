<?php

declare(strict_types=1);

namespace App\Shared\Application\ReadRepository;

/**
 * @template T
 */
final readonly class PaginatedCollectionDto
{
    /**
     * @param array<T> $items
     */
    public function __construct(
        public array $items,
        public PaginationDto $pagination
    ) {
    }
}
