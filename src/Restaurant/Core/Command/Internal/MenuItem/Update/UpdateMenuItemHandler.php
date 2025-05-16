<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Command\Internal\MenuItem\Update;

use App\Restaurant\Core\MenuItem\IMenuItemRepository;
use App\Shared\Application\Bus\Command\ICommandHandler;
use App\Shared\Application\Exception\NotFoundException;

class UpdateMenuItemHandler implements ICommandHandler
{
    public function __construct(
        private IMenuItemRepository $menuItemRepository,
    ) {
    }

    public function __invoke(UpdateMenuItemCommand $command): void
    {
        $menuItem = $this->menuItemRepository->findById($command->menuItem->id);
        NotFoundException::throwIfNull($menuItem, 'Menu item not found.');
        $menuItem->update($command->menuItem->name, $command->menuItem->price);
        $this->menuItemRepository->save($menuItem);
    }
}
