<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\Command\Internal\MenuItem\Create;

use App\MenuCatalog\Core\MenuItem\IMenuItemRepository;
use App\MenuCatalog\Core\MenuItem\MenuItem;
use App\Shared\Application\Bus\Command\ICommandHandler;

final class CreateMenuItemHandler implements ICommandHandler
{
    public function __construct(
        private IMenuItemRepository $menuItemRepository,
    ) {
    }

    public function __invoke(CreateMenuItemCommand $command): void
    {
        $menuItem = new MenuItem(
            $command->menuItem->id,
            $command->menuItem->name,
            $command->menuItem->price
        );
        $this->menuItemRepository->save($menuItem);
    }
}
