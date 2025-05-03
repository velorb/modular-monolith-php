<?php

declare(strict_types=1);

namespace App\MenuCatalog\Core\Command\Internal\MenuItem\Update;

use App\MenuCatalog\Core\Command\Internal\MenuItem\MenuItemDto;
use App\Shared\Application\Bus\Command\ICommand;

final readonly class UpdateMenuItemCommand implements ICommand
{
    public function __construct(
        public MenuItemDto $menuItem
    ) {
    }
}
