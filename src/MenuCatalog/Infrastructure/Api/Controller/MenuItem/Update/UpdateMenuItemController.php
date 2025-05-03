<?php

declare(strict_types=1);

namespace App\MenuCatalog\Infrastructure\Api\Controller\MenuItem\Update;

use App\MenuCatalog\Infrastructure\Api\Controller\MenuItem\MenuItemRequest;
use App\Shared\Application\Bus\Command\ICommandBus;
use App\Shared\Domain\MenuCatalog\MenuItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UpdateMenuItemController extends AbstractController
{
    public function __construct(
        private readonly ICommandBus $commandBus,
    ) {
    }

    #[Route('/api/menu-item/{id}', name: 'mc.menu-item.update', methods: ['PUT'])]
    public function __invoke(#[MapRequestPayload] MenuItemRequest $request, string $id): Response
    {
        $this->commandBus->dispatch($request->getUpdateCommand(new MenuItemId($id)));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
