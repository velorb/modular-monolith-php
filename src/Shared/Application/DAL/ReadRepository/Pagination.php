<?php

declare(strict_types=1);

namespace App\Shared\Application\DAL\ReadRepository;

final readonly class Pagination
{
    public const int DEFAULT_PAGE_SIZE = 10;
    public const int DEFAULT_CURRENT_PAGE = 1;

    public int $pageSize;
    public int $currentPage;

    public function __construct(
        ?int $pageSize,
        ?int $currentPage,
    ) {
        $this->pageSize = $pageSize ?? self::DEFAULT_PAGE_SIZE;
        $this->currentPage = $currentPage ?? self::DEFAULT_CURRENT_PAGE;
    }
}
