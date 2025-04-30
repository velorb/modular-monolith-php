<?php

declare(strict_types=1);

namespace App\Shared\Application\ReadRepository;

final readonly class PaginationDto
{
    public function __construct(
        public int $currentPage,
        public int $pageSize,
        public int $totalItems,
    ) {
    }
}
