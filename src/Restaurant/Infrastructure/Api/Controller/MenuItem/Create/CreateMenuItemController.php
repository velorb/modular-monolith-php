<?php

declare(strict_types=1);

namespace App\Restaurant\Infrastructure\Api\Controller\MenuItem\Create;

use App\Restaurant\Infrastructure\Api\Controller\MenuItem\MenuItemRequest;
use App\Shared\Application\Bus\Command\ICommandBus;
use App\Shared\Domain\Id\IUlidGenerator;
use App\Shared\Domain\Restaurant\MenuItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CreateMenuItemController extends AbstractController
{
    public function __construct(
        private readonly IUlidGenerator $idGenerator,
        private readonly ICommandBus $commandBus,
    ) {
    }

    #[Route('/api/menu-item', name: 'mc.menu-item.create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] MenuItemRequest $request): JsonResponse
    {
        $id = new MenuItemId($this->idGenerator->new()->value);
        $this->commandBus->dispatch($request->getCreateCommand($id));

        return $this->json(['id' => $id->value]);
    }
}
