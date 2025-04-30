<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\Api\Controller;

use App\Shared\Application\DAL\ReadRepository\Pagination;
use Symfony\Component\Validator\Constraints as Assert;

class CollectionRequestDto
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(100)]
        public ?int $pageSize = null,
        #[Assert\GreaterThanOrEqual(0)]
        public ?int $currentPage = null,
    ) {
    }

    public function getPagination(): Pagination
    {
        return new Pagination($this->pageSize, $this->currentPage);
    }
}
