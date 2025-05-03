<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\Api\Controller\MenuItem\Collection;

use App\MenuCatalog\Core\Query\Internal\MenuItem\Collection\GetMenuItemCollectionQuery;
use App\MenuCatalog\Infrastructure\Api\Controller\CollectionRequestDto;
use App\Shared\Application\Bus\Query\IQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/menu-item', name: 'mc.menu-item.collection', methods: ['GET'])]
class GetMenuItemCollectionController extends AbstractController
{
    public function __construct(
        private readonly IQueryBus $queryBus,
    ) {
    }

    public function __invoke(#[MapQueryString] CollectionRequestDto $request): JsonResponse
    {
        return $this->json(
            $this->queryBus->ask(
                new GetMenuItemCollectionQuery(
                    $request->getPagination()
                )
            )
        );
    }
}
