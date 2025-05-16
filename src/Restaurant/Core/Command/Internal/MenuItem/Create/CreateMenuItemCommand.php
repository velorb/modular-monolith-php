<?php

declare(strict_types=1);

namespace App\Restaurant\Core\Command\Internal\MenuItem\Create;

use App\Restaurant\Core\Command\Internal\MenuItem\MenuItemDto;
use App\Shared\Application\Bus\Command\ICommand;

final readonly class CreateMenuItemCommand implements ICommand
{
    public function __construct(
        public MenuItemDto $menuItem,
    ) {
    }
}
