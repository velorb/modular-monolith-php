<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/menu-item', name: 'mc.menu-item.collection', methods: ['GET'])]
class GetMenuItemCollectionController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return $this->json([]);
    }
}
